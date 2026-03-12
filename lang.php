<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set Language
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'th'; // Default
}

$lang = $_SESSION['lang'];

// Translations
$text = [
    'th' => [
        'home' => 'หน้าแรก',
        'history' => 'ประวัติ',
        'learning' => 'แหล่งเรียนรู้',
        'contact' => 'ติดต่อ',
        'identity' => 'อัตลักษณ์',
        'map' => 'แผนที่',
        'video_title' => 'วีดิทัศน์แนะนำแหล่งเรียนรู้',
        'read_more' => 'อ่านเพิ่มเติม',
        'province_title' => 'แหล่งเรียนรู้จังหวัดเพชรบุรี',
        'province_subtitle' => 'ดินแดนประวัติศาสตร์ ธรรมชาติ และศิลปกรรม',
        'contact_us' => 'ติดต่อเรา',
        'learning_center' => 'ศูนย์การเรียนรู้วัฒนธรรมจังหวัดเพชรบุรี',
        'video_recommend' => 'วิดีโอแนะนำ',
        'activities' => 'ภาพกิจกรรม / แหล่งเรียนรู้',
        'creators' => 'คณะผู้จัดทำ'
    ],
    'en' => [
        'home' => 'Home',
        'history' => 'History',
        'learning' => 'Learning',
        'contact' => 'Contact',
        'identity' => 'Identity',
        'map' => 'Map',
        'video_title' => 'Recommended Video',
        'read_more' => 'Read More',
        'province_title' => 'Phetchaburi Learning Media',
        'province_subtitle' => 'Land of History, Nature, and Art',
        'contact_us' => 'Contact Us',
        'learning_center' => 'Phetchaburi Cultural Learning Center',
        'video_recommend' => 'Featured Video',
        'activities' => 'Activities / Learning Resources',
        'creators' => 'Creators'
    ]
];

function get_content($row, $field) {
    global $lang;
    if ($lang == 'en' && !empty($row[$field . '_en'])) {
        return $row[$field . '_en'];
    }
    return $row[$field];
}
?>
