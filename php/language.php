<?php
session_start();

// Language translations
$languages = [
    'en' => [
        'welcome' => 'Welcome to the system',
        'login' => 'Login',
        'logout' => 'Logout',
        'manage_jobs' => 'Manage Jobs',
        'manage_trucks' => 'Truck Management',
        'manage_users' => 'Manage Users',
        'pincode_required' => 'Pincode is required.',
        'invalid_pincode' => 'Invalid pincode.',
        'truck_registered' => 'Truck registered successfully.',
        'arrival_status' => 'Truck arrival status updated.',
        'upload_success' => 'File uploaded successfully.',
        'upload_error' => 'Error uploading file.',
        'delete_success' => 'File deleted successfully.',
        'delete_confirm' => 'Are you sure you want to delete this file?'
    ],
    'ru' => [
        'welcome' => 'Добро пожаловать в систему',
        'login' => 'Войти',
        'logout' => 'Выход',
        'manage_jobs' => 'Управление работами',
        'manage_trucks' => 'Управление грузовиками',
        'manage_users' => 'Управление пользователями',
        'pincode_required' => 'Необходим пин-код.',
        'invalid_pincode' => 'Недействительный пин-код.',
        'truck_registered' => 'Грузовик успешно зарегистрирован.',
        'arrival_status' => 'Статус прибытия обновлен.',
        'upload_success' => 'Файл успешно загружен.',
        'upload_error' => 'Ошибка загрузки файла.',
        'delete_success' => 'Файл успешно удален.',
        'delete_confirm' => 'Вы уверены, что хотите удалить этот файл?'
    ],
    'et' => [
        'welcome' => 'Tere tulemast süsteemi',
        'login' => 'Logi sisse',
        'logout' => 'Logi välja',
        'manage_jobs' => 'Tööde haldamine',
        'manage_trucks' => 'Veokite haldamine',
        'manage_users' => 'Kasutajate haldamine',
        'pincode_required' => 'Pääsukood on vajalik.',
        'invalid_pincode' => 'Vale pääsukood.',
        'truck_registered' => 'Veok edukalt registreeritud.',
        'arrival_status' => 'Veoki saabumisolek on uuendatud.',
        'upload_success' => 'Fail on edukalt üles laaditud.',
        'upload_error' => 'Faili üleslaadimise viga.',
        'delete_success' => 'Fail on edukalt kustutatud.',
        'delete_confirm' => 'Kas olete kindel, et soovite selle faili kustutada?'
    ]
];

// Set language session
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $languages)) {
    $_SESSION['lang'] = $_GET['lang'];
}

// Default to English if no language is set
$lang = $_SESSION['lang'] ?? 'en';

// Function to translate text
function translate($key) {
    global $languages, $lang;
    return $languages[$lang][$key] ?? $key;
}
?>
