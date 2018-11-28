
<!-- Side-Nav -->
<ul id="slide-out" class="side-nav">
    <li><div class="user-view">
    <div class="background">
        <img src="{{asset('images/office.jpg')}}">
    </div>
    <a href="#!user"><img class="circle" src="{{asset('images/unknown.jpg')}}"></a>
    <a href="#!name"><span class="white-text name">{{Auth::user()->username}}</span></a>
    <a href="#!department"><span class="white-text email">{{Auth::user()->department->name}}</span></a>
    </div></li>

    <li><a href="/home"><i class="material-icons">folder_open</i>&nbsp; All Documents</a></li>
    <li><a href="/docu"><i class="material-icons">folder</i>&nbsp; My Documents</a></li>
    <!-- <li><a href="/intransit"><i class="material-icons">check</i> &nbsp; Receiving</a></li> -->
    <li><a href="/accepted"><i class="material-icons">check</i>&nbsp; Accepted Documents</a></li>
    <li><a href="/inactive"><i class="material-icons">error_outline</i>&nbsp; Inactive Documents</a></li>
    <li><a href="/receive"><i class="material-icons">note</i>&nbsp; Recieved Documents</a></li>
    <li><a href="/soft"><i class="material-icons">delete</i>&nbsp; Soft Deleted Documents</a></li>
    @if(Auth::user()->role->name == 'Super Admin')
    <li><a href="/users"><i class="material-icons">people</i>&nbsp; Manage Users</a></li>
    @endif
    <li><div class="divider"></div></li>
    <li><form action="{{route('logout')}}" method="POST">
        @csrf    
        <button class="btn btn-logout" type="submit" style="margin-left:30px;"><i class="fa fa-sign-out"></i>&nbsp; Logout </button>
    </form></li>
</ul>
<!-- End Side-Nav -->

