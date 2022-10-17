<div>
    <form method="POST" action="{{route('send.invite')}}">
        @csrf
        <input name="email" type="text"/>
    </form>
</div>
