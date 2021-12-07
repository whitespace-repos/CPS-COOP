<x-app-layout>    
    <!--  -->
    <form method="POST" action="{{ route('user.store') }}" class="container p-5">
        @csrf
        
        <div class="row">
            <!-- Shop Name -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name"  class="form-control" />
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="shop_id">Shop</label>
                    <select id="shop_id" name="shop_id"  autocomplete="shop-name" data-placeholder="Choose Shop"  class="custom-select">
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}" > {{ $shop->shop_name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role"  autocomplete="role-name" data-placeholder="Choose Role"  class="custom-select">
                        <option value="Employee">Employee</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email"  class="form-control" />
                </div>                
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password"  class="form-control" />
                </div>                
            </div>
            
            <div class="col-md-4">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone"  class="form-control" />
                </div>                
            </div>
        </div> 

        <input type="submit" class="btn btn-primary px-5 btn-sm" value="Create" />
    </form>
    @push('append-scripts')
        <script>
            $(document).ready(function(){
                $(".select2").select2();
            })
        </script>
    @endpush
</x-app-layout>
