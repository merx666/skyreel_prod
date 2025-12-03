<template>
  <nav class="fixed top-0 left-0 right-0 z-50 liquid-glass border-b border-glass-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <a href="/" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gradient-to-br from-accent to-blue-600 rounded-lg flex items-center justify-center">
              <span class="text-white font-bold text-sm">SR</span>
            </div>
            <span class="text-xl font-bold text-primary">SkyReel</span>
          </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">
            <a href="/" class="nav-link">Strona główna</a>
            <a href="/portfolios" class="nav-link">Portfolio</a>
            <a href="/jobs" class="nav-link">Zlecenia</a>
            <a href="/about" class="nav-link">O nas</a>
          </div>
        </div>

        <!-- Right side buttons -->
        <div class="hidden md:flex items-center space-x-4">
          <!-- Theme Toggle -->
          <button 
            @click="toggleTheme" 
            class="p-2 rounded-lg hover:bg-glass-hover transition-colors duration-200"
            :title="isDark ? 'Przełącz na jasny motyw' : 'Przełącz na ciemny motyw'"
          >
            <svg v-if="isDark" class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <svg v-else class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
          </button>

          <!-- Language Toggle -->
          <button 
            @click="toggleLanguage" 
            class="p-2 rounded-lg hover:bg-glass-hover transition-colors duration-200 text-sm font-medium text-secondary"
            :title="currentLang === 'pl' ? 'Switch to English' : 'Przełącz na polski'"
          >
            {{ currentLang === 'pl' ? 'EN' : 'PL' }}
          </button>

          <!-- User Menu -->
          <div class="relative" v-if="user">
            <button 
              @click="toggleUserMenu" 
              class="flex items-center space-x-2 p-2 rounded-lg hover:bg-glass-hover transition-colors duration-200"
            >
              <img 
                :src="user.profile_picture_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}`" 
                :alt="user.name"
                class="w-8 h-8 rounded-full"
              >
              <span class="text-sm font-medium text-primary">{{ user.name }}</span>
              <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>

            <!-- User Dropdown -->
            <div 
              v-if="showUserMenu" 
              class="absolute right-0 mt-2 w-48 liquid-glass rounded-lg shadow-lg py-1 z-50"
              @click.stop
            >
              <a href="/dashboard" class="block px-4 py-2 text-sm text-primary hover:bg-glass-hover">Dashboard</a>
              <a href="/profile" class="block px-4 py-2 text-sm text-primary hover:bg-glass-hover">Profil</a>
              <a v-if="user.role === 'operator'" href="/portfolios/create" class="block px-4 py-2 text-sm text-primary hover:bg-glass-hover">Dodaj Portfolio</a>
              <a v-if="user.role === 'client'" href="/jobs/create" class="block px-4 py-2 text-sm text-primary hover:bg-glass-hover">Dodaj Zlecenie</a>
              <hr class="my-1 border-glass-border">
              <form method="POST" action="/logout" class="block">
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-primary hover:bg-glass-hover">
                  Wyloguj się
                </button>
              </form>
            </div>
          </div>

          <!-- Guest Buttons -->
          <div v-else class="flex items-center space-x-2">
            <a href="/login" class="btn-secondary text-sm px-4 py-2">Zaloguj się</a>
            <a href="/register" class="btn-primary text-sm px-4 py-2">Zarejestruj się</a>
          </div>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden">
          <button 
            @click="toggleMobileMenu" 
            class="p-2 rounded-lg hover:bg-glass-hover transition-colors duration-200"
          >
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!showMobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="showMobileMenu" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 liquid-glass rounded-lg mt-2">
          <a href="/" class="block px-3 py-2 text-base font-medium text-primary hover:bg-glass-hover rounded-md">Strona główna</a>
          <a href="/portfolios" class="block px-3 py-2 text-base font-medium text-primary hover:bg-glass-hover rounded-md">Portfolio</a>
          <a href="/jobs" class="block px-3 py-2 text-base font-medium text-primary hover:bg-glass-hover rounded-md">Zlecenia</a>
          <a href="/about" class="block px-3 py-2 text-base font-medium text-primary hover:bg-glass-hover rounded-md">O nas</a>
          
          <hr class="my-2 border-glass-border">
          
          <!-- Mobile Theme & Language -->
          <div class="flex items-center justify-between px-3 py-2">
            <button @click="toggleTheme" class="flex items-center space-x-2 text-sm text-secondary">
              <svg v-if="isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
              </svg>
              <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
              </svg>
              <span>{{ isDark ? 'Jasny motyw' : 'Ciemny motyw' }}</span>
            </button>
            
            <button @click="toggleLanguage" class="text-sm font-medium text-secondary">
              {{ currentLang === 'pl' ? 'EN' : 'PL' }}
            </button>
          </div>
          
          <!-- Mobile User Menu -->
          <div v-if="user" class="px-3 py-2">
            <div class="flex items-center space-x-3 mb-3">
              <img 
                :src="user.profile_picture_url || `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}`" 
                :alt="user.name"
                class="w-8 h-8 rounded-full"
              >
              <span class="text-sm font-medium text-primary">{{ user.name }}</span>
            </div>
            <div class="space-y-1">
              <a href="/dashboard" class="block px-3 py-2 text-sm text-primary hover:bg-glass-hover rounded-md">Dashboard</a>
              <a href="/profile" class="block px-3 py-2 text-sm text-primary hover:bg-glass-hover rounded-md">Profil</a>
              <a v-if="user.role === 'operator'" href="/portfolios/create" class="block px-3 py-2 text-sm text-primary hover:bg-glass-hover rounded-md">Dodaj Portfolio</a>
              <a v-if="user.role === 'client'" href="/jobs/create" class="block px-3 py-2 text-sm text-primary hover:bg-glass-hover rounded-md">Dodaj Zlecenie</a>
              <form method="POST" action="/logout" class="block">
                <button type="submit" class="w-full text-left px-3 py-2 text-sm text-primary hover:bg-glass-hover rounded-md">
                  Wyloguj się
                </button>
              </form>
            </div>
          </div>
          
          <!-- Mobile Guest Buttons -->
          <div v-else class="px-3 py-2 space-y-2">
            <a href="/login" class="block btn-secondary text-center">Zaloguj się</a>
            <a href="/register" class="block btn-primary text-center">Zarejestruj się</a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'NavigationBar',
  props: {
    user: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      showUserMenu: false,
      showMobileMenu: false,
      isDark: true,
      currentLang: 'pl'
    }
  },
  mounted() {
    // Initialize theme from localStorage or system preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      this.isDark = savedTheme === 'dark';
    } else {
      this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
    this.applyTheme();

    // Initialize language from localStorage
    const savedLang = localStorage.getItem('language');
    if (savedLang) {
      this.currentLang = savedLang;
    }

    // Close menus when clicking outside
    document.addEventListener('click', this.closeMenus);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.closeMenus);
  },
  methods: {
    toggleUserMenu() {
      this.showUserMenu = !this.showUserMenu;
      this.showMobileMenu = false;
    },
    toggleMobileMenu() {
      this.showMobileMenu = !this.showMobileMenu;
      this.showUserMenu = false;
    },
    toggleTheme() {
      this.isDark = !this.isDark;
      this.applyTheme();
      localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
    },
    toggleLanguage() {
      this.currentLang = this.currentLang === 'pl' ? 'en' : 'pl';
      localStorage.setItem('language', this.currentLang);
      // Here you would typically trigger a language change event
      // or redirect to the same page with a different locale
      window.location.href = `/${this.currentLang}${window.location.pathname}`;
    },
    applyTheme() {
      if (this.isDark) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    },
    closeMenus(event) {
      if (!this.$el.contains(event.target)) {
        this.showUserMenu = false;
        this.showMobileMenu = false;
      }
    }
  }
}
</script>

<style scoped>
.nav-link {
  @apply text-secondary hover:text-primary transition-colors duration-200 px-3 py-2 rounded-md text-sm font-medium;
}

.nav-link:hover {
  @apply bg-glass-hover;
}
</style>