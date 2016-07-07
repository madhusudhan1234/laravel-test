<nav class="navbar navbar-default navbar-inverse">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Front End of Website</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <ul class="nav navbar-nav">
                <li><a href="{{ URL::to('/') }}">Home</a></li>
                <li><a href="{{ URL::to('carts') }}">View Carts <i class="ion ion-android-cart"></i></a></li>
            </ul>

            <ul class="nav navbar-nav pull-right">
                <li><a href="{{ URL::to('users/register') }}">Register</a></li>
                <li>{{ HTML::link('users/login', 'Login') }}</li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>