<div
    x-data="{
        show: true,
        timeout() {
            setTimeout(() => this.show = false, 4000)
        }
    }"
    x-init="timeout"
    x-show="show"
    x-transition
    class="fixed top-20 right-5 z-[100] space-y-3"
>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-lg">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="ml-2 text-green-600 hover:text-green-800">&times;</button>
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
            <button @click="show = false" class="ml-2 text-red-600 hover:text-red-800">&times;</button>
        </div>
    @endif

    {{-- INFO --}}
    @if(session('info'))
        <div class="flex items-center gap-3 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg shadow-lg">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01" />
            </svg>
            <span>{{ session('info') }}</span>
            <button @click="show = false" class="ml-2 text-blue-600 hover:text-blue-800">&times;</button>
        </div>
    @endif

</div>
