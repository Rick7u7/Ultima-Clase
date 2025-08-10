<div class="row">
                <div class="col-md-12">
                  <div class="nav-align-top">
                    <ul class="nav nav-pills flex-column flex-sm-row mb-6 gap-sm-0 gap-2">
                      <li class="nav-item">
                        <a class="nav-link
                        @if (strtolower(Route::currentRouteName()) == strtolower('Backoffice.User.Profile'))
                        active
                        @endif
                        " href="{{ route('backoffice.user.profile') }}"
                          ><i class="icon-base ti tabler-user-check icon-sm me-1_5"></i> Perfil</a
                        >
                      </li>
                      <li class="nav-item">
                        <a class="nav-link
                        @if (strtolower(Route::currentRouteName()) == strtolower('Backoffice.User.Contact'))
                        active
                        @endif
                        " href="{{ route('backoffice.user.contact') }}"
                          ><i class="icon-base ti tabler-users icon-sm me-1_5"></i> Contacto</a
                        >
                      </li>
                      <li class="nav-item">
                        <a class="nav-link
                        @if (strtolower(Route::currentRouteName()) == strtolower('Backoffice.User.Security'))
                        active
                        @endif
                        " href="{{ route('backoffice.user.security') }}"
                          ><i class="icon-base ti tabler-layout-grid icon-sm me-1_5"></i> Seguridad</a
                        >
                      </li>
                    </ul>
                  </div>
                </div>
              </div>