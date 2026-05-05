<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Simagang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen bg-slate-50 antialiased">
    <!-- KIRI - BIRU (Branding) -->
    <div class="hidden lg:flex w-1/2 bg-primary text-white flex-col justify-center p-16 relative overflow-hidden">
        <!-- Background Overlay Tipis (Sok-sokan mirip gambar) -->
        <div class="absolute inset-0 opacity-10 bg-[url('https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2670&auto=format&fit=crop')] bg-cover bg-center blend-overlay"></div>
        
        <div class="z-10 max-w-lg">
            <h1 class="text-4xl font-bold mb-4">Simagang</h1>
            <p class="text-blue-100 text-lg leading-relaxed mb-12">
                The unified digital portal for monitoring and managing internship programs (PKL). 
                Connect with industry partners and track your academic journey seamlessly.
            </p>

            <div class="flex gap-6">
                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl border border-white/20 flex-1">
                    <!-- CheckCircle2 SVG -->
                    <svg class="text-blue-200 mb-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                    <h3 class="font-semibold text-xl mb-2">Verified Partners</h3>
                    <p class="text-blue-100 text-sm">Access over 500+ institutional internship partners.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl border border-white/20 flex-1">
                    <!-- LayoutDashboard SVG -->
                    <svg class="text-blue-200 mb-3 w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    <h3 class="font-semibold text-xl mb-2">Real-time Tracking</h3>
                    <p class="text-blue-100 text-sm">Monitor progress and weekly reports instantly.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- KANAN - PUTIH (Form) -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="w-full max-w-md" x-data="loginComponent()">
            
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Welcome Back</h2>
            <p class="text-slate-500 mb-8">
                Sign in to your academic portal to continue your monitoring activity.
            </p>

            <form @submit.prevent="handleLogin()">
                
                <!-- Role Switcher -->
                <div class="mb-6 border border-slate-200 rounded-lg p-1 bg-slate-50 flex">
                    <template x-for="r in ['Mahasiswa', 'Dosen', 'Admin']" :key="r">
                        <button
                            type="button"
                            @click="role = r"
                            :class="{'bg-white text-primary shadow-sm border border-slate-200': role === r, 'text-slate-500 hover:text-slate-700': role !== r}"
                            class="flex-1 py-2 text-sm font-medium rounded-md flex items-center justify-center gap-2 transition-all"
                        >
                            <!-- User SVG -->
                            <svg x-show="r === 'Mahasiswa'" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <!-- BookOpen SVG -->
                            <svg x-show="r === 'Dosen'" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            <!-- Shield SVG -->
                            <svg x-show="r === 'Admin'" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.5 3.8 17 5 19 5a1 1 0 0 1 1 1z"/></svg>
                            <span x-text="r" class="ml-2"></span>
                        </button>
                    </template>
                </div>

                <!-- Error Message -->
                <div x-show="errorMsg" x-transition class="bg-red-50 text-red-500 text-sm p-3 rounded-lg mb-4 border border-red-200" x-text="errorMsg" style="display: none;"></div>

                <!-- Input ID -->
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-500 mb-2 uppercase tracking-wide">
                        IDENTIFICATION NUMBER <span x-text="role === 'Mahasiswa' ? '(NIM)' : role === 'Dosen' ? '(NIP)' : '(ID)'"></span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- IdCard SVG -->
                            <svg class="text-slate-400 w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                        </div>
                        <input
                            type="text"
                            required
                            x-model="username"
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 rounded-lg text-sm focus:ring-primary focus:border-primary placeholder-slate-400"
                            placeholder="Enter your ID number"
                        />
                    </div>
                </div>

                <!-- Input Password -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide">
                            Password
                        </label>
                        <a href="#" class="text-xs font-semibold text-primary hover:text-blue-700">
                            Forgot?
                        </a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- Lock SVG -->
                            <svg class="text-slate-400 w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            required
                            x-model="password"
                            class="block w-full pl-10 pr-10 py-3 border border-slate-200 rounded-lg text-sm focus:ring-primary focus:border-primary placeholder-slate-400"
                            placeholder="••••••••"
                        />
                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                        >
                            <!-- Eye/EyeOff SVG -->
                            <svg x-show="!showPassword" class="w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg x-show="showPassword" class="w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-primary hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors disabled:opacity-70 disabled:cursor-not-allowed"
                >
                    <span x-show="loading">Processing...</span>
                    <span x-show="!loading" class="flex items-center">
                        Sign In to Portal 
                        <!-- ArrowRight SVG -->
                        <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </span>
                </button>
            </form>
        </div>
    </div>

    <!-- Alpine.js Component Logic -->
    <script>
        function loginComponent() {
            return {
                role: 'Mahasiswa',
                username: '',
                password: '',
                showPassword: false,
                loading: false,
                errorMsg: '',

                getRoleValue(displayRole) {
                    if (displayRole === 'Mahasiswa') return 'student';
                    if (displayRole === 'Dosen') return 'lecturer';
                    return 'admin';
                },

                async handleLogin() {
                    this.loading = true;
                    this.errorMsg = '';

                    try {
                        // Request menggunakan fetch seperti React
                        const response = await fetch('/api/login', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                username: this.username,
                                password: this.password,
                                role: this.getRoleValue(this.role)
                            })
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 401) {
                                this.errorMsg = 'Username atau password salah.';
                            } else {
                                this.errorMsg = data.message || 'Terjadi kesalahan pada server. Cek koneksi.';
                            }
                            return;
                        }

                        // Simpan API Token
                        localStorage.setItem('sanctum_token', data.data.token);
                        localStorage.setItem('user', JSON.stringify(data.data.user));

                        // alert('Login Sukses sebagai ' + data.data.user.name);
                        const userRole = this.getRoleValue(this.role);
                        
                        if (userRole === 'student') {
                            window.location.href = '/dashboard/mahasiswa';
                        } else if (userRole === 'lecturer') {
                            window.location.href = '/dashboard/dosen';
                        } else if (userRole === 'admin') {
                            window.location.href = '/dashboard/admin';
                        }

                    } catch (err) {
                        this.errorMsg = 'Terjadi kesalahan jaringan.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
</body>
</html>
