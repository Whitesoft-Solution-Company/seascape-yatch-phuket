<x-app-layout>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="container mx-auto  xl:ml-64 lg:ml-64 ">
        <h1 class="text-2xl font-bold mb-4">Agent Management</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Create Agent Form -->
        <form action="{{ route('admin.agents.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="agent_name" placeholder="Agent Name" class="border p-2 rounded" required>
                <input type="text" name="agent_phone" placeholder="Agent Phone" class="border p-2 rounded" required>
                <input type="text" name="agent_web" placeholder="Agent Website" class="border p-2 rounded">
                <input type="text" name="address" placeholder="Address" class="border p-2 rounded">
                <input type="text" name="tex_number" placeholder="Tax Number" class="border p-2 rounded">
                <select name="type_user" class="border p-2 rounded">
                    <option value="0">อื่นๆ</option>
                    <option value="1" selected>Agent ทั่วไป</option>
                    <option value="2">ในเครือ</option>
                    <option value="3">ตรง</option>
                    <option value="4">credit</option>
                </select>
                <select name="agent_status" class="border p-2 rounded">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Create Agent</button>
        </form>

        <!-- Agent List -->
        <table class="w-full border-collapse border border-gray-300" id="mytable">
            <thead>
                <tr>
                    <th class="border p-2">Name</th>
                    <th class="border p-2">Phone</th>
                    <th class="border p-2">Website</th>
                    <th class="border p-2">Address</th>
                    <th class="border p-2">Credit</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agents as $agent)
                    <tr>
                        <td class="border p-2">{{ $agent->agent_name }}</td>
                        <td class="border p-2">{{ $agent->agent_phone }}</td>
                        <td class="border p-2">{{ $agent->agent_web }}</td>
                        <td class="border p-2">{{ $agent->address }}</td>
                        <td class="border p-2">{{ $agent->credit }}</td>
                        <td class="border p-2 flex space-x-2">
                            <!-- Edit Button -->
                            <button onclick="openEditModal({{ $agent }})"
                                class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.agents.destroy', $agent) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div id="editModal"
        class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-1/2">
            <h2 class="text-xl font-bold mb-4">Edit Agent</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editAgentId" name="agent_id">
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" id="editAgentName" name="agent_name" placeholder="Agent Name"
                        class="border p-2 rounded" required>
                    <input type="text" id="editAgentPhone" name="agent_phone" placeholder="Agent Phone"
                        class="border p-2 rounded" required>
                    <input type="url" id="editAgentWeb" name="agent_web" placeholder="Agent Website"
                        class="border p-2 rounded">
                    <input type="text" id="editAddress" name="address" placeholder="Address"
                        class="border p-2 rounded">
                    <input type="text" id="editTexNumber" name="tex_number" placeholder="Tax Number"
                        class="border p-2 rounded">
                    <select id="editTypeUser" name="type_user" class="border p-2 rounded">
                        <option value="0">อื่นๆ</option>
                        <option value="1">Agent ทั่วไป</option>
                        <option value="2">ในเครือ</option>
                        <option value="3">ตรง</option>
                        <option value="4">credit</option>
                    </select>
                    <select id="editAgentStatus" name="agent_status" class="border p-2 rounded">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Update Agent</button>
                <button type="button" onclick="closeEditModal()"
                    class="mt-4 bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Validation Failed',
            text: @json($errors->all())
        });
    </script>
@endif
    <script>
         $(document).ready(function() {
      
        const table =  $('#mytable').DataTable({
            "paging": true,      
            "searching": true,   
            "info": true,         
            "ordering": true,    
            "order": [[0, "asc"]], 
          
        });

      

       
    });
        function openEditModal(agent) {
            document.getElementById('editModal').classList.remove('hidden');
    
    // ตั้งค่าข้อมูลในฟอร์ม
    document.getElementById('editAgentId').value = agent.id;
    document.getElementById('editAgentName').value = agent.agent_name;
    document.getElementById('editAgentPhone').value = agent.agent_phone;
    document.getElementById('editAgentWeb').value = agent.agent_web;
    document.getElementById('editAddress').value = agent.address;
    document.getElementById('editTexNumber').value = agent.tex_number;
    document.getElementById('editTypeUser').value = agent.type_user;
    document.getElementById('editAgentStatus').value = agent.agent_status;
    
    // แก้ไข URL action ของฟอร์ม
    document.getElementById('editForm').action = `/admin/agents/${agent.id}`;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>


</x-app-layout>
