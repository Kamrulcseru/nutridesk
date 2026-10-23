@extends('layouts.admin')

@section('title', 'Add New User')
@section('page_title', 'Create User & Assign Role')

@section('content')
<div class="max-w-3xl bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm space-y-6">
    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
        <div>
            <h3 class="text-xl font-bold text-slate-900">Add New System User</h3>
            <p class="text-xs text-slate-500">Create super admin, staff / operations, dietitian or customer account</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="text-xs text-emerald-700 font-bold hover:underline">
            &larr; Back to Users
        </a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Password *</label>
                <input type="password" name="password" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border" placeholder="Minimum 6 characters">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Role / Permissions *</label>
                <select name="role" required class="w-full text-xs rounded-xl border-slate-200 p-2.5 border font-semibold">
                    <option value="customer">Customer</option>
                    <option value="staff">Staff / Delivery & Kitchen Ops</option>
                    <option value="dietitian">Dietitian / Nutritionist</option>
                    <option value="super_admin">Super Admin (Full Permission)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Office Name</label>
                <input type="text" name="office_name" value="{{ old('office_name') }}" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Floor</label>
                <input type="text" name="office_floor" value="{{ old('office_floor') }}" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Desk #</label>
                <input type="text" name="desk_number" value="{{ old('desk_number') }}" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Health Condition</label>
                <select name="health_condition" class="w-full text-xs rounded-xl border-slate-200 p-2.5 border">
                    <option value="general">General</option>
                    <option value="diabetes">Diabetes</option>
                    <option value="kidney">Kidney</option>
                    <option value="heart">Heart</option>
                </select>
            </div>
        </div>

        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" checked class="rounded text-emerald-600 focus:ring-emerald-500">
                <span class="text-xs font-bold text-slate-700">Account is Active</span>
            </label>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50">Cancel</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md">Create User</button>
        </div>
    </form>
</div>
@endsection
