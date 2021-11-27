<x-cps-layout>
    <h4 class="mt-4">Employees</h4>
    
    <hr class="mb-5 mt-4" />    
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th width="100">#</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>            
            @foreach($employees as $employee)
            <tr> 
                <td><kbd>#{{ $loop->iteration }}</kbd></td>               
                <td>{{ $employee['Name'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</x-cps-layout>
