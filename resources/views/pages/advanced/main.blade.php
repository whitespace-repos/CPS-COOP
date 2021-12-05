<x-app-layout>
    <div class="table-responsive">
        <table class="table table-striped table-sm  ">
            <thead class="bg-dark text-white">
                <tr>
                    <th>Group</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($setting_groups as $group)
                    <tr>
                        <td>{{ $group->group }}</td>
                        <td> 
                            <a href="{{ route('settings.edit',$group->id) }}" class="badge badge-dark">Edit</a>                            
                        </td>
                    </tr>
                @endforeach                
            </tbody>
        </table>
    </div> 
</x-app-layout>
