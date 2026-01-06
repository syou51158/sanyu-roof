<?php require_once __DIR__ . '/../config/config.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO -->
    <title><?php echo isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME . ' | 京都市伏見区の屋根修理・雨漏り工事'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : '京都市伏見区の' . SITE_NAME . '。屋根修理、雨漏り修理、葺き替え工事ならお任せください。地域密着、職人直営で安心価格。お見積もり無料。'; ?>">
    <link rel="canonical" href="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    
    <!-- OGP -->
    <meta property="og:title" content="<?php echo isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>/assets/img/ogp.jpg">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:description" content="京都の屋根修理・雨漏り工事は山勇ルーフへ。">
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- JSON-LD (LocalBusiness) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "RoofingContractor",
      "name": "<?php echo COMPANY_NAME; ?>",
      "image": "<?php echo SITE_URL; ?>/assets/img/logo.png",
      "@id": "<?php echo SITE_URL; ?>",
      "url": "<?php echo SITE_URL; ?>",
      "telephone": "<?php echo COMPANY_PHONE; ?>",
      "priceRange": "¥¥",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "羽束師菱川町511-1",
        "addressLocality": "京都市伏見区",
        "addressRegion": "京都府",
        "postalCode": "612-8487",
        "addressCountry": "JP"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": 34.9275, 
        "longitude": 135.7333
      },
      "openingHoursSpecification": {
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": [
          "Monday",
          "Tuesday",
          "Wednesday",
          "Thursday",
          "Friday",
          "Saturday"
        ],
        "opens": "08:00",
        "closes": "19:00"
      }
    }
    </script>
</head>
<body>
