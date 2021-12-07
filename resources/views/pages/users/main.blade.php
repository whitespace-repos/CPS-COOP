<x-app-layout>
    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm my-4">Add User </a>
    <div class="table-responsive">
        <table class="table table-striped table-sm  ">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Shop</th>
                    <th>contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td> 
                           {{ $user->getRoleNames()->get(0) }}
                        </td>
                        <td>{{ $user->shop->shop_name ?? '-' }}
                        </td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td> 
                            <a href="{{ route('user.edit',$user->id) }}">Edit</a>
                            <form action="{{ route('user.destroy',$user->id) }}" method="POST" class="d-inline-flex ml-2">                                
                                @csrf 
                                @method("DELETE")
                                <!--  -->
                                <input type="submit" class="py-0 btn btn-link btn-xs"  value="Remove" />
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        
    </x-app-layout>
    