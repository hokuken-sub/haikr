<html>
  <body>
    <nav class="navigation">
      @section('navigation')
        <a href="/">Home</a>
        <a href="/about">About</a>
      @show
    </nav>
 
    <div class="container">
       @yield('content')
    </div>
     
    <div class="sidebar">
       @yield('sidebar')
    </div>
  </body>
</html>