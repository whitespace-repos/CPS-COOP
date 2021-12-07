<x-app-layout>    
    <!--  -->
    <form method="POST" action="{{ route('user.update',$user->id) }}" class="container p-5">
        @csrf
        @method('PATCH')
        <div class="row">
            <!-- Shop Name -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name"  class="form-control" value="{{ $user->name }}"/>
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="shop">Shop</label>
                    <select id="shop" name="shop_id"  autocomplete="shop-name" data-placeholder="Choose Shop"  class="custom-select">                        
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}"  @if($user->shop_id == $shop->id) {{ _('selected') }} @endif > {{ $shop->shop_name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role"  autocomplete="role-name" data-placeholder="Choose Role"  class="custom-select">
                        <option value="Employee" @if($user->getRoleNames()->get(0) == 'Employee') {{ _('selected') }} @endif>Employee</option>
                        <option value="Admin" @if($user->getRoleNames()->get(0) == 'Admin') {{ _('selected') }} @endif>Admin</option>
                    </select>
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email"  class="form-control" value="{{ $user->email }}"/>
                </div>                
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone"  class="form-control" value="{{ $user->phone }}"/>
                </div>                
            </div>
        </div> 

        <input type="submit" class="btn btn-primary px-5 btn-sm" value="Update" />
    </form>
    @push('append-scripts')
        <script>
            $(document).ready(function(){
                $(".select2").select2();
            })
        </script>
    @endpush
</x-app-layout>
