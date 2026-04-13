@extends('client.quizzes.index')

@section('title', 'Thông tin cá nhân - Quiz STU')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 page-fade">

    <div>
        <h2 class="text-4xl font-bold text-primary mb-2">Thông tin cá nhân</h2>
        <p class="text-slate-500">Xem và cập nhật hồ sơ của bạn.</p>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
            <span class="material-symbols-outlined text-green-500">check_circle</span>{{ session('success') }}
        </div>
    @endif
    @if(session('success_password'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
            <span class="material-symbols-outlined text-green-500">lock</span>{{ session('success_password') }}
        </div>
    @endif

    {{-- ─── Profile card ─── --}}
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
        {{-- Top banner --}}
        <div class="h-20 bg-gradient-to-r from-primary to-secondary relative">
            <span class="material-symbols-outlined absolute right-6 bottom-0 translate-y-1/2 opacity-20 text-[5rem] text-white">account_circle</span>
        </div>

        <div class="px-8 pb-8">
            {{-- Avatar + read-only info --}}
            <div class="flex flex-col sm:flex-row items-start gap-6 -mt-10 mb-8">
                <div class="relative flex-shrink-0">
                    @if($user->photo && file_exists(public_path('storage/' . $user->photo)))
                        <img src="{{ asset('storage/' . $user->photo) }}"
                             alt="Avatar"
                             class="w-20 h-20 rounded-2xl border-4 border-white shadow-md object-cover">
                    @else
                        <div class="w-20 h-20 rounded-2xl border-4 border-white shadow-md bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-primary/40">person</span>
                        </div>
                    @endif
                </div>
                <div class="mt-10 sm:mt-12">
                    <h3 class="text-2xl font-extrabold text-primary">{{ $user->last_name }} {{ $user->first_name }}</h3>
                    <p class="text-slate-500 text-sm mt-0.5">{{ $user->email }}</p>
                    @if($user->student_code)
                        <span class="inline-block mt-1 px-2 py-0.5 bg-primary/10 text-primary rounded-full text-xs font-bold font-mono">MSSV: {{ $user->student_code }}</span>
                    @endif
                </div>
            </div>

            {{-- Read-only info grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8 p-5 bg-slate-50 rounded-2xl">
                @php
                    $infoFields = [
                        ['label' => 'Khoa', 'value' => $user->faculty->name ?? '—', 'icon' => 'school'],
                        ['label' => 'Lớp', 'value' => $user->schoolClass->name ?? '—', 'icon' => 'groups'],
                        ['label' => 'Nhóm thi', 'value' => $user->userGroup->name ?? '—', 'icon' => 'group_work'],
                        ['label' => 'Niên khóa', 'value' => $user->academic_year ?? '—', 'icon' => 'calendar_today'],
                        ['label' => 'Hệ đào tạo', 'value' => $user->degree_type ?? '—', 'icon' => 'verified'],
                    ];
                @endphp
                @foreach($infoFields as $field)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-primary text-base">{{ $field['icon'] }}</span>
                    </div>
                    <div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">{{ $field['label'] }}</p>
                        <p class="text-sm font-semibold text-slate-700">{{ $field['value'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Editable form --}}
            <form method="POST" action="{{ route('client.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <h4 class="font-bold text-primary mb-4 flex items-center gap-2 text-sm uppercase tracking-wider">
                    <span class="material-symbols-outlined text-base">edit</span>Cập nhật thông tin
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- Phone --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Số điện thoại</label>
                        <input type="tel" name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="0901 234 567"
                               class="w-full border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary transition-colors {{ $errors->has('phone') ? 'border-red-400' : 'border-slate-200' }}">
                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Birthdate --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Ngày sinh</label>
                        <input type="date" name="birthdate"
                               value="{{ old('birthdate', $user->birthdate?->format('Y-m-d')) }}"
                               class="w-full border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary transition-colors {{ $errors->has('birthdate') ? 'border-red-400' : 'border-slate-200' }}">
                        @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Photo --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Ảnh đại diện</label>
                        <div class="flex items-center gap-4">
                            <label class="cursor-pointer flex items-center gap-3 px-4 py-2.5 border border-dashed border-slate-300 rounded-xl hover:border-primary transition-colors group">
                                <span class="material-symbols-outlined text-slate-400 group-hover:text-primary transition-colors">upload</span>
                                <span id="photo-label" class="text-sm text-slate-500 group-hover:text-primary transition-colors">Chọn ảnh (jpg, png, webp — tối đa 2MB)</span>
                                <input type="file" name="photo" class="hidden" accept="image/jpeg,image/png,image/webp"
                                       onchange="document.getElementById('photo-label').textContent = this.files[0]?.name || 'Chọn ảnh'">
                            </label>
                        </div>
                        @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="px-8 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:-translate-y-0.5 transition-all shadow-md hover:shadow-primary/30">
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── Change Password ─── --}}
    <div id="password-section" class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
        <h4 class="font-bold text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-wider">
            <span class="material-symbols-outlined text-base">lock</span>Đổi mật khẩu
        </h4>

        <form method="POST" action="{{ route('client.profile.password') }}">
            @csrf
            @method('PATCH')
            <div class="space-y-4 max-w-md">

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" autocomplete="current-password"
                           class="w-full border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary transition-colors {{ $errors->has('current_password') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Mật khẩu mới</label>
                    <input type="password" name="new_password" autocomplete="new-password"
                           class="w-full border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary transition-colors {{ $errors->has('new_password') ? 'border-red-400' : 'border-slate-200' }}">
                    @error('new_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5 uppercase tracking-wider">Xác nhận mật khẩu mới</label>
                    <input type="password" name="new_password_confirmation" autocomplete="new-password"
                           class="w-full border rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary transition-colors">
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="px-8 py-3 bg-primary text-white rounded-xl font-bold text-sm hover:-translate-y-0.5 transition-all shadow-md hover:shadow-primary/30">
                        Đổi mật khẩu
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
