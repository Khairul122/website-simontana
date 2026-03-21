<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title><?php echo $title ?? 'SIMONTANA - Sistem Informasi Monitoring Bencana'; ?></title>
  
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
              700: '#b91c1c',  /* Primary UI Red */
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
    /* Global scrollbar */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Fix utility classes for old views temporarily */
    .container-scroller { display: flex; height: 100vh; overflow: hidden; background-color: #f8fafc; }
    .page-body-wrapper { display: flex; flex: 1; flex-direction: column; overflow: hidden; }
    .main-panel { flex: 1; display: flex; flex-direction: column; overflow-y: auto; overflow-x: hidden; }
    .content-wrapper { padding: 1.5rem; flex: 1; width: 100%; max-width: 1600px; margin: 0 auto; }
    
    @media (min-width: 1024px) {
      .container-scroller { flex-direction: row; }
      .page-body-wrapper { flex-direction: column; }
    }

    /* Custom classes */
    .glass-nav { 
      background: rgba(255, 255, 255, 0.85); 
      backdrop-filter: blur(12px); 
      -webkit-backdrop-filter: blur(12px); 
      border-bottom: 1px solid rgba(226, 232, 240, 0.8);
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased">
