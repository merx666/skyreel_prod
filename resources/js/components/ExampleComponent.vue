<template>
    <div class="liquid-glass p-6 m-4 hover-glow">
        <h2 class="text-2xl font-semibold mb-4 text-dark-accent">SkyReel</h2>
        <p class="text-dark-text-secondary">
            Witaj w SkyReel - platformie łączącej operatorów dronów z klientami!
        </p>
        <button 
            @click="toggleTheme" 
            class="mt-4 px-4 py-2 bg-dark-accent text-white rounded-lg hover:bg-opacity-80 transition-colors"
        >
            Przełącz motyw
        </button>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
    name: 'ExampleComponent',
    setup() {
        const isDark = ref(true)
        
        const toggleTheme = () => {
            isDark.value = !isDark.value
            if (isDark.value) {
                document.documentElement.classList.add('dark')
                document.documentElement.classList.remove('light')
            } else {
                document.documentElement.classList.add('light')
                document.documentElement.classList.remove('dark')
            }
        }
        
        onMounted(() => {
            // Ustaw domyślny motyw ciemny
            document.documentElement.classList.add('dark')
        })
        
        return {
            toggleTheme
        }
    }
}
</script>