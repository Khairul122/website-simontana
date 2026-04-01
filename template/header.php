<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <?php
    $seoTitle = $title ?? 'SIMONTANA - Sistem Informasi Monitoring Bencana';
    $seoDescription = $metaDescription ?? 'SIMONTANA membantu monitoring bencana, verifikasi laporan, tindak lanjut lapangan, dan informasi BMKG secara terintegrasi.';
    $seoKeywords = $metaKeywords ?? 'simontana, monitoring bencana, laporan bencana, bmkg, bpbd, operator desa, petugas bpbd';
    $seoImage = $metaImage ?? 'assets/images/favicon.png';
    $seoUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? '/');
    $baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');

    if (strpos($seoImage, 'http') !== 0) {
      $seoImage = rtrim($baseUrl, '/') . '/' . ltrim($seoImage, '/');
    }

    $schemaGraph = [];

    $schemaGraph[] = [
      '@type' => 'Organization',
      '@id' => $baseUrl . '/#organization',
      'name' => 'SIMONTANA',
      'url' => $baseUrl,
      'logo' => $seoImage,
      'description' => $seoDescription,
    ];

    $schemaGraph[] = [
      '@type' => 'WebSite',
      '@id' => $baseUrl . '/#website',
      'url' => $baseUrl,
      'name' => 'SIMONTANA',
      'inLanguage' => 'id-ID',
      'publisher' => ['@id' => $baseUrl . '/#organization'],
    ];

    $schemaGraph[] = [
      '@type' => 'WebPage',
      '@id' => $seoUrl . '#webpage',
      'url' => $seoUrl,
      'name' => $seoTitle,
      'description' => $seoDescription,
      'inLanguage' => 'id-ID',
      'isPartOf' => ['@id' => $baseUrl . '/#website'],
      'primaryImageOfPage' => ['@type' => 'ImageObject', 'url' => $seoImage],
    ];

    if (isset($schemaBreadcrumbs) && is_array($schemaBreadcrumbs) && !empty($schemaBreadcrumbs)) {
      $itemList = [];
      $position = 1;
      foreach ($schemaBreadcrumbs as $crumb) {
        if (!is_array($crumb) || empty($crumb['name']) || empty($crumb['url'])) {
          continue;
        }
        $itemList[] = [
          '@type' => 'ListItem',
          'position' => $position++,
          'name' => (string)$crumb['name'],
          'item' => (string)$crumb['url'],
        ];
      }

      if (!empty($itemList)) {
        $schemaGraph[] = [
          '@type' => 'BreadcrumbList',
          '@id' => $seoUrl . '#breadcrumb',
          'itemListElement' => $itemList,
        ];
      }
    }

    $schemaJson = [
      '@context' => 'https://schema.org',
      '@graph' => $schemaGraph,
    ];
  ?>
  <title><?php echo htmlspecialchars($seoTitle); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($seoDescription); ?>" />
  <meta name="keywords" content="<?php echo htmlspecialchars($seoKeywords); ?>" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="<?php echo htmlspecialchars($seoUrl); ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:locale" content="id_ID" />
  <meta property="og:title" content="<?php echo htmlspecialchars($seoTitle); ?>" />
  <meta property="og:description" content="<?php echo htmlspecialchars($seoDescription); ?>" />
  <meta property="og:url" content="<?php echo htmlspecialchars($seoUrl); ?>" />
  <meta property="og:site_name" content="SIMONTANA" />
  <meta property="og:image" content="<?php echo htmlspecialchars($seoImage); ?>" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?php echo htmlspecialchars($seoTitle); ?>" />
  <meta name="twitter:description" content="<?php echo htmlspecialchars($seoDescription); ?>" />
  <meta name="twitter:image" content="<?php echo htmlspecialchars($seoImage); ?>" />
  <script type="application/ld+json"><?php echo json_encode($schemaJson, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?></script>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="shortcut icon" href="assets/images/favicon.png" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'sans-serif'],
            display: ['Space Grotesk', 'sans-serif']
          },
          colors: {
            brand: {
              50: '#fef2f2',
              100: '#fee2e2',
              200: '#fecaca',
              300: '#fca5a5',
              400: '#f87171',
              500: '#ef4444',
              600: '#dc2626',
              700: '#b91c1c',  
              800: '#991b1b',
              900: '#7f1d1d'
            },
            slate: {
              850: '#152033',
              900: '#0f172a'
            }
          },
          boxShadow: {
            'card': '0 4px 20px rgba(0, 0, 0, 0.03)',
            'float': '0 10px 30px rgba(185, 28, 28, 0.08)',
          },
          animation: {
            'fade-in': 'fadeIn 0.3s ease-out',
            'slide-up': 'slideUp 0.4s ease-out',
            'pulse-soft': 'pulseSoft 3s infinite',
          },
          keyframes: {
            fadeIn: {
              '0%': { opacity: '0' },
              '100%': { opacity: '1' },
            },
            slideUp: {
              '0%': { opacity: '0', transform: 'translateY(10px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            pulseSoft: {
              '0%, 100%': { opacity: '1' },
              '50%': { opacity: '.7' },
            }
          }
        }
      }
    }
  </script>

  <style>
    
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    
    .container-scroller { display: flex; height: 100vh; overflow: hidden; background-color: #f8fafc; }
    .page-body-wrapper { display: flex; flex: 1; flex-direction: column; overflow: hidden; }
    .main-panel { flex: 1; display: flex; flex-direction: column; overflow-y: auto; overflow-x: hidden; }
    .content-wrapper { padding: 1.5rem; flex: 1; width: 100%; max-width: 1600px; margin: 0 auto; }
    
    @media (min-width: 1024px) {
      .container-scroller { flex-direction: row; }
      .page-body-wrapper { flex-direction: column; }
    }

    
    .glass-nav { 
      background: rgba(255, 255, 255, 0.85); 
      backdrop-filter: blur(12px); 
      -webkit-backdrop-filter: blur(12px); 
      border-bottom: 1px solid rgba(226, 232, 240, 0.8);
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
