<!doctype html>
<html lang="es" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
  data-skin="default" data-assets-path="/vuexy/assets/" data-template="vertical-menu-template" data-bs-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Historial de Pagos | Sonkei FC</title>

  <!-- Favicon y fuentes -->
  <link rel="icon" type="image/x-icon" href="/vuexy/assets/img/favicon/favicon.ico" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/fonts/iconify-icons.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/css/core.css" />
  <link rel="stylesheet" href="/vuexy/assets/css/demo.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet" href="/vuexy/assets/vendor/css/pages/page-profile.css" />

  <script src="/vuexy/assets/vendor/js/helpers.js"></script>
  <script src="/vuexy/assets/vendor/js/template-customizer.js"></script>
  <script src="/vuexy/assets/js/config.js"></script>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      @include('backoffice/_partials/aside', ['user' => $user, 'datos' => $datos ?? null])

      <div class="menu-mobile-toggler d-xl-none rounded-1">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
          <i class="ti tabler-menu icon-base"></i>
          <i class="ti tabler-chevron-right icon-base"></i>
        </a>
      </div>

      <div class="layout-page">
        <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
              <i class="icon-base ti tabler-menu-2 icon-md"></i>
            </a>
          </div>
          @include('backoffice/_partials/topbar', ['user' => $user])
        </nav>

        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            @include('backoffice/users/_partials/header', ['user' => $user, 'persona' => $persona])
            @include('backoffice/users/_partials/menu', ['user' => $user])

            <div class="card mb-4">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Historial de Pagos</h5>
              </div>
              <div class="card-body">
                @if ($saldos->isEmpty())
                  <div class="alert alert-warning mb-0">Este usuario no tiene pagos registrados.</div>
                @else
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead class="table-light">
                        <tr>
                          <th>Mes</th>
                          <th>Año</th>
                          <th>Monto</th>
                          <th>Estado</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($saldos as $saldo)
                          <tr>
                            <td>{{ str_pad($saldo->mes, 2, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $saldo->año }}</td>
                            <td>${{ number_format($saldo->monto, 0, ',', '.') }}</td>
                            <td>
                              <span class="badge 
                                @switch($saldo->estado)
                                  @case('pagado') bg-success @break
                                  @case('pendiente') bg-warning text-dark @break
                                  @case('atrasado') bg-danger @break
                                  @default bg-secondary
                                @endswitch">
                                {{ ucfirst($saldo->estado) }}
                              </span>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                @endif
              </div>
            </div>
          </div>

          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
              <div class="footer-container d-flex justify-content-between py-4">
                <div class="text-body">© {{ date('Y') }}, Sonkei FC</div>
              </div>
            </div>
          </footer>

          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="/vuexy/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="/vuexy/assets/vendor/js/bootstrap.js"></script>
  <script src="/vuexy/assets/vendor/js/menu.js"></script>
  <script src="/vuexy/assets/js/main.js"></script>
</body>
</html>
