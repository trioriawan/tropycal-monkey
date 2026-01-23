@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-bold text-gray-700">Data Users</h3>
        <button onclick="openAddModal()" class="bg-[#4DBE68] text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-600 transition shadow-sm">
            + Tambah User
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-[11px] font-bold">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Name Users</th>
                    <th class="px-4 py-3 text-center">Opsi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($users as $index => $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-4">{{ $index + 1 }}</td>
                    <td class="px-4 py-4 text-blue-500 underline">{{ $user->email }}</td>
                    <td class="px-4 py-4 text-gray-700 font-medium">{{ $user->name }}</td>
                    <td class="px-4 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button 
                                onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')"
                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded text-[11px] font-bold transition">
                                Edit
                            </button>
                            
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded text-[11px] font-bold transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div id="userModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="p-6 border-b bg-gray-50">
            <h2 id="modalTitle" class="font-bold text-gray-800 text-lg">Tambah User</h2>
        </div>
        
        <form id="userForm" method="POST">
            @csrf
            <div id="methodField"></div> <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="userName" class="w-full border rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                    <input type="email" name="email" id="userEmail" class="w-full border rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password</label>
                    <input type="password" name="password" id="userPassword" placeholder="Isi jika ingin ganti/buat baru" class="w-full border rounded-lg px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-green-500">
                    <p id="passHint" class="text-[10px] text-gray-400 mt-1 hidden">*Kosongkan jika tidak ingin mengubah password</p>
                </div>
            </div>

            <div class="p-6 bg-gray-50 border-t flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700 font-bold text-sm">Batal</button>
                <button type="submit" class="bg-[#4DBE68] hover:bg-green-600 text-white px-6 py-2 rounded-lg font-bold text-sm transition">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('userModal');
    const form = document.getElementById('userForm');
    const modalTitle = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');
    const passHint = document.getElementById('passHint');

    function openAddModal() {
        modalTitle.innerText = "Tambah User Baru";
        form.action = "{{ route('users.store') }}";
        methodField.innerHTML = ""; // POST biasa
        form.reset();
        passHint.classList.add('hidden');
        modal.classList.remove('hidden');
    }

    function openEditModal(id, name, email) {
        modalTitle.innerText = "Edit Data User";
        form.action = "/users/" + id; // Mengarah ke route update
        methodField.innerHTML = '@method("PUT")'; // Inject method PUT
        
        document.getElementById('userName').value = name;
        document.getElementById('userEmail').value = email;
        document.getElementById('userPassword').value = ""; // Reset password field
        
        passHint.classList.remove('hidden');
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection