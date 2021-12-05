<x-app-layout>
    <!--  -->    
    <form method="POST" action="{{ route('settings.store') }}" class="form-inline w-75 justify-content-center my-4 mx-auto">
        <input type="hidden" name="setting_group_id" value="{{ $setting_group->id }}" />
        @csrf       
        <div class="form-group m-2">
            <label for="staticEmail2" class="sr-only">Group</label>
            <div class="form-control bg-light px-5  text-left" >{{ $setting_group->group }}</div>
        </div>
        <div class="form-group m-2">                              
            <input type="text" name="value" id="value" autocomplete="value-level2"  placeholder="Value" value="" class="form-control">                         
        </div>
        
        <div class="form-group m-2">       
            <input type="text" name="key" id="key" autocomplete="key-level2" value=""   placeholder="Key"  class="form-control">                         
        </div>
        <button type="submit" class="btn btn-dark m-2 px-4">Add</button>
    </form>
        
    <!--  -->        
    <div class="table-responsive">
        <table class="table table-striped table-sm" >
            <thead>
                <tr>
                    <th>Group </th>
                    <th>Value </th>
                    <th>Key </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($setting_group->options as $key => $option)
                    <tr>
                        <td>{{ $setting_group->group }}</td>
                        <td>{{ $option->value }}</td>
                        <td>{{ $option->key }}</td>
                        <td>                                    
                            <form action="{{ route('settings.destroy',$option->id) }}" method="POST" class="inline-block ">                                
                                @csrf 
                                @method("DELETE")
                                <!--  -->
                                <input type="submit" class="py-0 btn btn-info btn-xs"  value="Remove" />
                            </form>
                        </td>
                    </tr> 
                @endforeach                        
                <!-- More people... -->
            </tbody>
        </table>
    </div>
</x-app-layout>
