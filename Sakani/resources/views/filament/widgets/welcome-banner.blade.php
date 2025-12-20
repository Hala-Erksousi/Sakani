<div class="relative overflow-hidden rounded-2xl bg-gradient-to-tr from-teal-600 to-cyan-500 p-8 shadow-lg border border-teal-400/20 mb-6">
    <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
    
    <div class="relative z-10 flex items-center justify-between text-white">
        <div class="space-y-4">
            <h1 class="text-4xl font-black tracking-tight leading-tight">
                Welcome Back to Sakani System ✨
            </h1>
            
            <p class="text-xl font-medium text-teal-50 flex items-center gap-2">
                <span class="inline-block p-1 bg-white/20 rounded-lg">
                    <x-filament::icon icon="heroicon-m-bell-alert" class="w-6 h-6" />
                </span>
                 You currently have <span class="font-bold underline decoration-white/50 text-2xl">{{ \App\Models\User::where('is_verified', false)->count() }}</span> Registrations pending review.
            </p>
        </div>

        <div class="hidden lg:block opacity-20 transform -rotate-12">
            <x-filament::icon icon="heroicon-o-home-modern" class="h-32 w-32" />
        </div>
    </div>
</div>