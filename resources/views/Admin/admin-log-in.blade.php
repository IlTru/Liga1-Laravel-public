<div class="log-in" style="background-color: rgb(0, 100, 0); padding:250px 0px 0px 650px; height: 550px; margin: 0px;">
    <form method="post" action="{{url('admin-auth')}}" style="background-color: green; width: 260px; border: solid black 2px; padding: 10px">
        @csrf
        <div>
            <div><label> Email: </label> <input type="email" name="email" value="alextrusca1919@gmail.com"></div>
            <br> <br>
            <div><label> Parolă: </label> <input type="password" name="password"></div>
            <br> <br>
        </div>
        <button type="submit" style="margin-left: 100px;">Log In</button><br><br>
        @if ($errors->has('email')) {{ $errors->first('email') }} <br> @endif
        Dacă nu sunteți admin al paginii apasați <a href="http://localhost/Liga1/public/home">aici</a>!
    </form>
</div>