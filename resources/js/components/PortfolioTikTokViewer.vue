<template>
  <div class="portfolio-tiktok-viewer h-96 relative overflow-hidden rounded-2xl bg-black">
    <div 
      v-if="portfolios.length > 0"
      class="h-full snap-y snap-mandatory overflow-y-scroll scrollbar-hide"
      ref="scrollContainer"
      @scroll="handleScroll"
    >
      <div 
        v-for="(portfolio, index) in portfolios" 
        :key="portfolio.id"
        class="h-full snap-start relative flex items-center justify-center"
        :class="{ 'active': currentIndex === index }"
      >
        <!-- Background Media -->
        <div class="absolute inset-0 z-0">
          <div 
            v-if="portfolio.media_items && portfolio.media_items.length > 0"
            class="w-full h-full"
          >
            <!-- Video Background -->
            <div 
              v-if="portfolio.media_items[0].type === 'video'"
              class="w-full h-full relative"
            >
              <iframe
                :src="portfolio.media_items[0].source_url + '?autoplay=1&mute=1&loop=1&controls=0'"
                class="w-full h-full object-cover"
                frameborder="0"
                allow="autoplay; encrypted-media"
                allowfullscreen
              ></iframe>
            </div>
            
            <!-- Image Background -->
            <div 
              v-else
              class="w-full h-full bg-cover bg-center"
              :style="{ backgroundImage: `url(${portfolio.media_items[0].source_url})` }"
            ></div>
          </div>
          
          <!-- Fallback gradient -->
          <div 
            v-else
            class="w-full h-full bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900"
          ></div>
          
          <!-- Overlay -->
          <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>

        <!-- Content Overlay -->
        <div class="relative z-10 w-full h-full flex flex-col justify-end p-6 text-white">
          <!-- User Info -->
          <div class="flex items-center mb-4">
            <img 
              :src="portfolio.user.profile_picture_url"
              :alt="portfolio.user.name"
              class="w-12 h-12 rounded-full border-2 border-white mr-3"
            >
            <div>
              <h3 class="font-semibold text-lg">{{ portfolio.user.name }}</h3>
              <p class="text-sm text-gray-300">{{ portfolio.user.location }}</p>
            </div>
          </div>

          <!-- Portfolio Info -->
          <div class="mb-4">
            <h2 class="text-2xl font-bold mb-2">{{ portfolio.title }}</h2>
            <p class="text-sm text-gray-200 line-clamp-3">{{ portfolio.description }}</p>
          </div>

          <!-- Action Buttons -->
          <div class="flex space-x-3">
            <a 
              :href="`/portfolios/${portfolio.slug}`"
              class="bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2 rounded-full text-white hover:bg-opacity-30 transition-all duration-200 flex items-center"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
              Zobacz Portfolio
            </a>
            
            <a 
              :href="`/profile/${portfolio.user.id}`"
              class="bg-accent bg-opacity-80 backdrop-blur-sm px-4 py-2 rounded-full text-white hover:bg-opacity-100 transition-all duration-200 flex items-center"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              Profil
            </a>
          </div>
        </div>

        <!-- Navigation Dots -->
        <div class="absolute right-4 top-1/2 transform -translate-y-1/2 flex flex-col space-y-2 z-20">
          <button
            v-for="(dot, dotIndex) in portfolios"
            :key="dotIndex"
            @click="scrollToIndex(dotIndex)"
            class="w-2 h-2 rounded-full transition-all duration-200"
            :class="currentIndex === dotIndex ? 'bg-white' : 'bg-white/30'"
          ></button>
        </div>

        <!-- Media Counter -->
        <div 
          v-if="portfolio.media_items && portfolio.media_items.length > 1"
          class="absolute top-4 right-4 bg-black bg-opacity-50 backdrop-blur-sm px-3 py-1 rounded-full text-white text-sm z-20"
        >
          {{ portfolio.media_items.length }} {{ portfolio.media_items.length === 1 ? 'element' : 'elementów' }}
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="h-full flex items-center justify-center text-white">
      <div class="text-center">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
        <h3 class="text-xl font-semibold mb-2">Brak portfolio</h3>
        <p class="text-gray-300 mb-4">Nie ma jeszcze żadnych portfolio do wyświetlenia</p>
        <a href="/register" class="bg-accent px-6 py-2 rounded-full text-white hover:bg-accent-dark transition-colors">
          Zostań operatorem
        </a>
      </div>
    </div>

    <!-- Scroll Progress -->
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-white bg-opacity-20 z-20">
      <div 
        class="h-full bg-accent transition-all duration-300"
        :style="{ width: `${scrollProgress}%` }"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PortfolioTikTokViewer',
  props: {
    portfolios: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      currentIndex: 0,
      scrollProgress: 0
    }
  },
  methods: {
    handleScroll() {
      const container = this.$refs.scrollContainer;
      if (!container) return;

      const scrollTop = container.scrollTop;
      const scrollHeight = container.scrollHeight - container.clientHeight;
      const itemHeight = container.clientHeight;
      
      // Calculate current index
      this.currentIndex = Math.round(scrollTop / itemHeight);
      
      // Calculate scroll progress
      this.scrollProgress = (scrollTop / scrollHeight) * 100;
    },
    
    scrollToIndex(index) {
      const container = this.$refs.scrollContainer;
      if (!container) return;

      const itemHeight = container.clientHeight;
      container.scrollTo({
        top: index * itemHeight,
        behavior: 'smooth'
      });
    },
    
    scrollToNext() {
      if (this.currentIndex < this.portfolios.length - 1) {
        this.scrollToIndex(this.currentIndex + 1);
      }
    },
    
    scrollToPrevious() {
      if (this.currentIndex > 0) {
        this.scrollToIndex(this.currentIndex - 1);
      }
    }
  },
  mounted() {
    // Auto-scroll every 10 seconds
    this.autoScrollInterval = setInterval(() => {
      if (this.portfolios.length > 1) {
        const nextIndex = (this.currentIndex + 1) % this.portfolios.length;
        this.scrollToIndex(nextIndex);
      }
    }, 10000);

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowDown' || e.key === ' ') {
        e.preventDefault();
        this.scrollToNext();
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        this.scrollToPrevious();
      }
    });
  },
  beforeUnmount() {
    if (this.autoScrollInterval) {
      clearInterval(this.autoScrollInterval);
    }
  }
}
</script>

<style scoped>
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.snap-container {
  scroll-snap-type: y mandatory;
}

.snap-item {
  scroll-snap-align: start;
}

.portfolio-tiktok-viewer {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>