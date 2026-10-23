@extends('layouts.admin')

@section('title', 'User & Role Management')
@section('page_title', app()->getLocale() == 'bn' ? 'ইউজার ও রোল পারমিশন ম্যানেজমেন্ট' : 'Users & Roles Management')

@section('content')
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone..." class="text-xs rounded-xl border-slate-200 focus:border-emerald-500 p-2.5 border w-48 sm:w-60">

            <select name="role" class="text-xs rounded-xl border-slate-200 focus:border-emerald-500 p-2.5 border" onchange="this.form.submit()">
                <option value="">{{ app()->getLocale() == 'bn' ? 'সকল রোল' : 'All Roles' }}</option>
                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff / Kitchen</option>
                <option value="dietitian" {{ request('role') === 'dietitian' ? 'selected' : '' }}>Dietitian</option>
                <option value="customer" {{ request('role') === 'customer' ? 'selected' : '' }}>Customer</option>
            </select>

            <button type="submit" class="bg-slate-900 text-white text-xs font-bold px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">
                <i class="fa-solid fa-search mr-1"></i> Search
            </button>
        </form>

        <a href="{{ route('admin.users.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-user-plus"></i>
            <span>{{ app()->getLocale() == 'bn' ? 'নতুন ইউজার তৈরি করুন' : 'Add New User' }}</span>
        </a>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-900 uppercase tracking-wider font-bold border-b border-slate-100">
                    <tr>
                        <th class="p-4">User</th>
                        <th class="p-4">Role / Permissions</th>
                        <th class="p-4">Phone</th>
                        <th class="p-4">Office / Desk</th>
                        <th class="p-4">Health Condition</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 block text-sm">{{ $u->name }}</span>
                                        <span class="text-slate-400 text-[11px]">{{ $u->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($u->role === 'super_admin')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-amber-100 text-amber-900 border border-amber-300">
                                        Super Admin
                                    </span>
                                @elseif($u->role === 'staff')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-blue-100 text-blue-900 border border-blue-300">
                                        Staff / Ops
                                    </span>
                                @elseif($u->role === 'dietitian')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-purple-100 text-purple-900 border border-purple-300">
                                        Dietitian
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                        Customer
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 font-medium text-slate-800">{{ $u->phone ?? 'N/A' }}</td>
                            <td class="p-4 text-slate-600">
                                @if($u->office_name)
                                    <span class="font-medium text-slate-800 block">{{ $u->office_name }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $u->office_floor }}, {{ $u->desk_number }}</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <span class="capitalize font-semibold text-slate-700">{{ $u->health_condition }}</span>
                            </td>
                            <td class="p-4">
                                @if($u->is_active)
                                    <span class="text-emerald-600 font-bold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @else
                                    <span class="text-rose-500 font-bold flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700" title="Edit User">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600" title="Delete User">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
