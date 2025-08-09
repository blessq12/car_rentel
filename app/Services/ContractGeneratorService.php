<?php

namespace App\Services;

use App\Models\Deal;
use App\Enums\DealType;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class ContractGeneratorService
{
    public function generateContract(Deal $deal): string
    {
        $html = $this->generateContractHtml($deal);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('fontDir', storage_path('fonts/'));
        $options->set('fontCache', storage_path('fonts/'));

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = "contract_deal_{$deal->id}_" . date('Y-m-d_H-i-s') . '.pdf';
        $path = "contracts/{$filename}";

        // Создаем папку если её нет
        $fullPath = storage_path("app/public/{$path}");
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Сохраняем файл напрямую
        file_put_contents($fullPath, $dompdf->output());

        return $path;
    }

    private function generateContractHtml(Deal $deal): string
    {
        $contractTemplate = match ($deal->deal_type) {
            DealType::RENTAL_WITHOUT_DEPOSIT => $this->getRentalWithoutDepositTemplate(),
            DealType::RENTAL_WITH_DEPOSIT => $this->getRentalWithDepositTemplate(),
            DealType::RENT_TO_OWN => $this->getRentToOwnTemplate(),
        };

        return $this->replacePlaceholders($contractTemplate, $deal);
    }

    private function getRentalWithoutDepositTemplate(): string
    {
        return '
        <html>
        <head>
            <meta charset="utf-8">
            <title>Договор аренды без залога</title>
            <style>
                @font-face {
                    font-family: "DejaVu Sans";
                    src: url("' . storage_path('fonts/DejaVuSans.ttf') . '") format("truetype");
                }
                body {
                    font-family: "DejaVu Sans", Arial, sans-serif;
                    font-size: 12px;
                    line-height: 1.4;
                    margin: 20px;
                }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; margin-bottom: 20px; }
                .section { margin-bottom: 20px; }
                .section-title { font-weight: bold; margin-bottom: 10px; }
                .signature { margin-top: 50px; }
                .signature-line { border-top: 1px solid #000; width: 200px; display: inline-block; margin: 0 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="title">ДОГОВОР АРЕНДЫ АВТОМОБИЛЯ БЕЗ ЗАЛОГА</div>
                <p>№ {DEAL_ID} от {DEAL_DATE}</p>
            </div>

            <div class="section">
                <div class="section-title">1. СТОРОНЫ ДОГОВОРА</div>
                <p><strong>Арендодатель:</strong> {OWNER_NAME}, паспорт: {OWNER_PASSPORT}, адрес: {OWNER_ADDRESS}</p>
                <p><strong>Арендатор:</strong> {RENTER_NAME}, паспорт: {RENTER_PASSPORT}, адрес: {RENTER_ADDRESS}</p>
            </div>

            <div class="section">
                <div class="section-title">2. ПРЕДМЕТ ДОГОВОРА</div>
                <p>Арендодатель передает, а Арендатор принимает во временное пользование автомобиль:</p>
                <p><strong>Марка/модель:</strong> {CAR_BRAND} {CAR_MODEL}</p>
                <p><strong>Год выпуска:</strong> {CAR_YEAR}</p>
                <p><strong>Гос. номер:</strong> {CAR_NUMBER}</p>
                <p><strong>VIN:</strong> {CAR_VIN}</p>
            </div>

            <div class="section">
                <div class="section-title">3. СРОК АРЕНДЫ</div>
                <p><strong>Начало:</strong> {START_DATE}</p>
                <p><strong>Окончание:</strong> {END_DATE}</p>
                <p><strong>Продолжительность:</strong> {DURATION} дней</p>
            </div>

            <div class="section">
                <div class="section-title">4. СТОИМОСТЬ АРЕНДЫ</div>
                <p><strong>Стоимость за день:</strong> {DAILY_PRICE} рублей</p>
                <p><strong>Общая стоимость:</strong> {TOTAL_PRICE} рублей</p>
                <p><strong>Залог:</strong> Не предусмотрен</p>
            </div>

            <div class="section">
                <div class="section-title">5. ОБЯЗАННОСТИ СТОРОН</div>
                <p><strong>Арендодатель обязуется:</strong></p>
                <ul>
                    <li>Передать автомобиль в исправном техническом состоянии</li>
                    <li>Предоставить все необходимые документы</li>
                </ul>
                <p><strong>Арендатор обязуется:</strong></p>
                <ul>
                    <li>Использовать автомобиль по назначению</li>
                    <li>Своевременно оплачивать аренду</li>
                    <li>Возвратить автомобиль в установленный срок</li>
                </ul>
            </div>

            <div class="signature">
                <p><strong>Арендодатель:</strong> <span class="signature-line"></span> / {OWNER_NAME} /</p>
                <p><strong>Арендатор:</strong> <span class="signature-line"></span> / {RENTER_NAME} /</p>
            </div>
        </body>
        </html>';
    }

    private function getRentalWithDepositTemplate(): string
    {
        return '
        <html>
        <head>
            <meta charset="utf-8">
            <title>Договор аренды с залогом</title>
            <style>
                @font-face {
                    font-family: "DejaVu Sans";
                    src: url("' . storage_path('fonts/DejaVuSans.ttf') . '") format("truetype");
                }
                body {
                    font-family: "DejaVu Sans", Arial, sans-serif;
                    font-size: 12px;
                    line-height: 1.4;
                    margin: 20px;
                }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; margin-bottom: 20px; }
                .section { margin-bottom: 20px; }
                .section-title { font-weight: bold; margin-bottom: 10px; }
                .signature { margin-top: 50px; }
                .signature-line { border-top: 1px solid #000; width: 200px; display: inline-block; margin: 0 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="title">ДОГОВОР АРЕНДЫ АВТОМОБИЛЯ С ЗАЛОГОМ</div>
                <p>№ {DEAL_ID} от {DEAL_DATE}</p>
            </div>

            <div class="section">
                <div class="section-title">1. СТОРОНЫ ДОГОВОРА</div>
                <p><strong>Арендодатель:</strong> {OWNER_NAME}, паспорт: {OWNER_PASSPORT}, адрес: {OWNER_ADDRESS}</p>
                <p><strong>Арендатор:</strong> {RENTER_NAME}, паспорт: {RENTER_PASSPORT}, адрес: {RENTER_ADDRESS}</p>
            </div>

            <div class="section">
                <div class="section-title">2. ПРЕДМЕТ ДОГОВОРА</div>
                <p>Арендодатель передает, а Арендатор принимает во временное пользование автомобиль:</p>
                <p><strong>Марка/модель:</strong> {CAR_BRAND} {CAR_MODEL}</p>
                <p><strong>Год выпуска:</strong> {CAR_YEAR}</p>
                <p><strong>Гос. номер:</strong> {CAR_NUMBER}</p>
                <p><strong>VIN:</strong> {CAR_VIN}</p>
            </div>

            <div class="section">
                <div class="section-title">3. СРОК АРЕНДЫ</div>
                <p><strong>Начало:</strong> {START_DATE}</p>
                <p><strong>Окончание:</strong> {END_DATE}</p>
                <p><strong>Продолжительность:</strong> {DURATION} дней</p>
            </div>

            <div class="section">
                <div class="section-title">4. СТОИМОСТЬ АРЕНДЫ И ЗАЛОГ</div>
                <p><strong>Стоимость за день:</strong> {DAILY_PRICE} рублей</p>
                <p><strong>Общая стоимость:</strong> {TOTAL_PRICE} рублей</p>
                <p><strong>Залог:</strong> {DEPOSIT_AMOUNT} рублей</p>
                <p><strong>Условия возврата залога:</strong> Залог возвращается при возврате автомобиля в исправном состоянии</p>
            </div>

            <div class="section">
                <div class="section-title">5. ОБЯЗАННОСТИ СТОРОН</div>
                <p><strong>Арендодатель обязуется:</strong></p>
                <ul>
                    <li>Передать автомобиль в исправном техническом состоянии</li>
                    <li>Предоставить все необходимые документы</li>
                    <li>Вернуть залог при возврате автомобиля в исправном состоянии</li>
                </ul>
                <p><strong>Арендатор обязуется:</strong></p>
                <ul>
                    <li>Использовать автомобиль по назначению</li>
                    <li>Своевременно оплачивать аренду</li>
                    <li>Возвратить автомобиль в установленный срок</li>
                    <li>Внести залог в размере {DEPOSIT_AMOUNT} рублей</li>
                </ul>
            </div>

            <div class="signature">
                <p><strong>Арендодатель:</strong> <span class="signature-line"></span> / {OWNER_NAME} /</p>
                <p><strong>Арендатор:</strong> <span class="signature-line"></span> / {RENTER_NAME} /</p>
            </div>
        </body>
        </html>';
    }

    private function getRentToOwnTemplate(): string
    {
        return '
        <html>
        <head>
            <meta charset="utf-8">
            <title>Договор аренды с правом выкупа</title>
            <style>
                @font-face {
                    font-family: "DejaVu Sans";
                    src: url("' . storage_path('fonts/DejaVuSans.ttf') . '") format("truetype");
                }
                body {
                    font-family: "DejaVu Sans", Arial, sans-serif;
                    font-size: 12px;
                    line-height: 1.4;
                    margin: 20px;
                }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; margin-bottom: 20px; }
                .section { margin-bottom: 20px; }
                .section-title { font-weight: bold; margin-bottom: 10px; }
                .signature { margin-top: 50px; }
                .signature-line { border-top: 1px solid #000; width: 200px; display: inline-block; margin: 0 10px; }
            </style>
        </head>
        <body>
            <div class="header">
                <div class="title">ДОГОВОР АРЕНДЫ С ПРАВОМ ВЫКУПА</div>
                <p>№ {DEAL_ID} от {DEAL_DATE}</p>
            </div>

            <div class="section">
                <div class="section-title">1. СТОРОНЫ ДОГОВОРА</div>
                <p><strong>Арендодатель:</strong> {OWNER_NAME}, паспорт: {OWNER_PASSPORT}, адрес: {OWNER_ADDRESS}</p>
                <p><strong>Арендатор:</strong> {RENTER_NAME}, паспорт: {RENTER_PASSPORT}, адрес: {RENTER_ADDRESS}</p>
            </div>

            <div class="section">
                <div class="section-title">2. ПРЕДМЕТ ДОГОВОРА</div>
                <p>Арендодатель передает, а Арендатор принимает во временное пользование автомобиль с правом последующего выкупа:</p>
                <p><strong>Марка/модель:</strong> {CAR_BRAND} {CAR_MODEL}</p>
                <p><strong>Год выпуска:</strong> {CAR_YEAR}</p>
                <p><strong>Гос. номер:</strong> {CAR_NUMBER}</p>
                <p><strong>VIN:</strong> {CAR_VIN}</p>
            </div>

            <div class="section">
                <div class="section-title">3. СРОК АРЕНДЫ</div>
                <p><strong>Начало:</strong> {START_DATE}</p>
                <p><strong>Окончание:</strong> {END_DATE}</p>
                <p><strong>Продолжительность:</strong> {DURATION} дней</p>
            </div>

            <div class="section">
                <div class="section-title">4. СТОИМОСТЬ И УСЛОВИЯ ВЫКУПА</div>
                <p><strong>Стоимость за день:</strong> {DAILY_PRICE} рублей</p>
                <p><strong>Общая стоимость аренды:</strong> {TOTAL_PRICE} рублей</p>
                <p><strong>Стоимость выкупа:</strong> {BUYOUT_PRICE} рублей</p>
                <p><strong>Условия выкупа:</strong> Арендатор имеет право выкупить автомобиль в любое время в течение срока аренды</p>
            </div>

            <div class="section">
                <div class="section-title">5. ОБЯЗАННОСТИ СТОРОН</div>
                <p><strong>Арендодатель обязуется:</strong></p>
                <ul>
                    <li>Передать автомобиль в исправном техническом состоянии</li>
                    <li>Предоставить все необходимые документы</li>
                    <li>Оформить передачу права собственности при выкупе</li>
                </ul>
                <p><strong>Арендатор обязуется:</strong></p>
                <ul>
                    <li>Использовать автомобиль по назначению</li>
                    <li>Своевременно оплачивать аренду</li>
                    <li>Принять решение о выкупе в установленный срок</li>
                </ul>
            </div>

            <div class="signature">
                <p><strong>Арендодатель:</strong> <span class="signature-line"></span> / {OWNER_NAME} /</p>
                <p><strong>Арендатор:</strong> <span class="signature-line"></span> / {RENTER_NAME} /</p>
            </div>
        </body>
        </html>';
    }

    private function replacePlaceholders(string $template, Deal $deal): string
    {
        $metadata = $deal->metadata ?? [];
        $owner = $deal->owner;
        $ownerName = $deal->owner_name;

        $replacements = [
            '{DEAL_ID}' => $deal->id,
            '{DEAL_DATE}' => $deal->created_at->format('d.m.Y'),
            '{OWNER_NAME}' => $ownerName,
            '{OWNER_PASSPORT}' => $metadata['owner_passport'] ?? 'не указан',
            '{OWNER_ADDRESS}' => $metadata['owner_address'] ?? 'не указан',
            '{RENTER_NAME}' => $deal->renter->name,
            '{RENTER_PASSPORT}' => $metadata['renter_passport'] ?? 'не указан',
            '{RENTER_ADDRESS}' => $metadata['renter_address'] ?? 'не указан',
            '{CAR_BRAND}' => $deal->car->brand,
            '{CAR_MODEL}' => $deal->car->model,
            '{CAR_YEAR}' => $deal->car->year,
            '{CAR_NUMBER}' => $deal->car->license_plate ?? 'не указан',
            '{CAR_VIN}' => $deal->car->vin ?? 'не указан',
            '{START_DATE}' => $deal->start_date->format('d.m.Y'),
            '{END_DATE}' => $deal->end_date->format('d.m.Y'),
            '{DURATION}' => $deal->start_date->diffInDays($deal->end_date),
            '{DAILY_PRICE}' => number_format($metadata['daily_price'] ?? 0),
            '{TOTAL_PRICE}' => number_format($metadata['total_price'] ?? 0),
            '{DEPOSIT_AMOUNT}' => number_format($metadata['deposit'] ?? 0),
            '{BUYOUT_PRICE}' => number_format($metadata['buyout_price'] ?? 0),
        ];

        $result = str_replace(array_keys($replacements), array_values($replacements), $template);

        return $result;
    }
}
