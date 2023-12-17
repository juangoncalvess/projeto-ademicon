<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">
        <meta name="theme-color" content="#ce2616">
        <link rel="icon" href="{{ asset('img/icon.png') }}">
    </head>
    <body url="{{ asset('') }}" token-auth=""> 
        <header>
            @if(Request::segment(1) == 'painel')
                <div class="menu-mobile">
                    <a class="menu-mobile-logo"></a>
                    <a class="menu-mobile-icon"></a>
                </div>
                <div class="menu-lateral-engloba">
                    <div class="menu-lateral">
                        <div class="menu-lateral-logo"></div>
                        <div class="menu-lateral-links"> 
                            <a href="{{ asset('painel') }}" class="{{ (Request::segment(1) == 'painel' && Request::segment(2) == '' ? 'menu-lateral-ativo' : '') }}">
                                <ion-icon name="pie-chart-outline"></ion-icon>
                                <p>Dashboard</p>  
                            </a>
                            <a href="{{ asset('painel/vendedores/listar') }}" class="{{ (Request::segment(2) == 'vendedores' ? 'menu-lateral-ativo' : '') }}">
                                <ion-icon name="id-card-outline"></ion-icon>
                                <p>Vendedores</p>
                            </a>
                            <a href="{{ asset('painel/clientes/listar') }}" class="{{ (Request::segment(2) == 'clientes' ? 'menu-lateral-ativo' : '') }}">
                                <ion-icon name="people-outline"></ion-icon>
                                <p>Clientes</p>
                            </a>
                            <a href="{{ asset('painel/produtos/listar') }}" class="{{ (Request::segment(2) == 'produtos' ? 'menu-lateral-ativo' : '') }}">
                                <ion-icon name="cube-outline"></ion-icon>
                                <p>Produtos</p>
                            </a>
                            <a href="{{ asset('painel/vendas/listar') }}" class="{{ (Request::segment(2) == 'vendas' ? 'menu-lateral-ativo' : '') }}">
                                <ion-icon name="cart-outline"></ion-icon>
                                <p>Vendas</p>
                            </a>                     
                        </div>
                        <div class="menu-lateral-fundo"> 
                            <form class="form-fake2" action="{{ asset('logout') }}" method="POST">
                                @csrf
                                <button>
                                    <a>
                                        <ion-icon name="log-out-outline"></ion-icon>
                                        <p>Logout</p>
                                    </a>
                                </button>
                            </form> 
                        </div>
                    </div>
                    <div class="menu-lateral-fechar"></div>
                </div>
            @endif
        </header>
        <main>
            <div class="loading">
                <div class="engloba-loading">
                    <div class="square-center">
                        <div class="lds-roller">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </main>
        <footer>

        </footer>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
        <script src="{{ asset('js/funcoes.js') }}"></script>
        @if(Request::segment(2) == "")
            <script src="{{ asset('js/dashboard.js') }}"></script>    
        @else
            <script src="{{ asset('js/'.Request::segment(2).'.js') }}"></script>    
        @endif 
    </body> 
</html> 
