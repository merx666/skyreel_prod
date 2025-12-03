<template>
  <div class="portfolio-viewer">
    <!-- Background with blur effect -->
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40"></div>
    
    <!-- Close button -->
    <button
      @click="$emit('close')"
      class="fixed top-4 right-4 z-50 p-2 bg-black/20 backdrop-blur-sm rounded-full text-white hover:bg-black/30 transition-colors"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
    
    <!-- TikTok-style scroll container -->
    <TikTokScrollContainer :items="mediaItems" ref="scrollContainer">
      <template #default="{ item, index, isActive }">
        <div class="w-full h-full flex items-center justify-center p-4">
          <!-- Video Content -->
          <div v-if="item.type === 'video'" class="relative w-full max-w-md h-full flex flex-col">
            <!-- YouTube Embed -->
            <div class="flex-1 flex items-center justify-center">
              <div class="w-full aspect-video bg-black rounded-liquid overflow-hidden">
                <iframe
                  v-if="isActive"
                  :src="getYouTubeEmbedUrl(item.source_url)"
                  class="w-full h-full"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen
                ></iframe>
                <div v-else class="w-full h-full flex items-center justify-center">
                  <img :src="item.thumbnail_url" :alt="item.title" class="w-full h-full object-cover" />
                </div>
              </div>
            </div>
            
            <!-- Video Info -->
            <div class="mt-4 text-center">
              <h3 class="text-white text-lg font-semibold mb-2">{{ item.title }}</h3>
              <p class="text-white/80 text-sm">{{ item.description }}</p>
            </div>
          </div>
          
          <!-- Image Content -->
          <div v-else-if="item.type === 'image'" class="relative w-full max-w-4xl h-full flex flex-col">
            <div class="flex-1 flex items-center justify-center">
              <img 
                :src="item.source_url" 
                :alt="item.title"
                class="max-w-full max-h-full object-contain rounded-liquid"
              />
            </div>
            
            <!-- Image Info -->
            <div class="mt-4 text-center">
              <h3 class="text-white text-lg font-semibold mb-2">{{ item.title }}</h3>
              <p class="text-white/80 text-sm">{{ item.description }}</p>
            </div>
          </div>
        </div>
        
        <!-- Side Panel with Portfolio Info -->
        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10">
          <div class="liquid-glass p-4 max-w-xs">
            <!-- Operator Info -->
            <div class="flex items-center mb-4">
              <div class="w-12 h-12 bg-gradient-to-br from-dark-accent to-dark-accent/70 rounded-full flex items-center justify-center">
                <span class="text-white font-semibold">{{ getOperatorInitials(portfolio.user.name) }}</span>
              </div>
              <div class="ml-3">
                <h4 class="text-primary font-semibold">{{ portfolio.user.name }}</h4>
                <p class="text-secondary text-sm">{{ portfolio.user.profile?.location }}</p>
              </div>
            </div>
            
            <!-- Portfolio Title -->
            <h3 class="text-primary font-semibold text-lg mb-2">{{ portfolio.title }}</h3>
            
            <!-- Description -->
            <p class="text-secondary text-sm mb-4">{{ portfolio.description }}</p>
            
            <!-- Actions -->
            <div class="space-y-2">
              <button class="w-full btn-primary text-sm py-2">
                Skontaktuj się
              </button>
              <button class="w-full btn-secondary text-sm py-2">
                Zobacz profil
              </button>
            </div>
          </div>
        </div>
      </template>
    </TikTokScrollContainer>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import TikTokScrollContainer from './TikTokScrollContainer.vue'

const props = defineProps({
  portfolio: {
    type: Object,
    required: true
  },
  startIndex: {
    type: Number,
    default: 0
  }
})

defineEmits(['close'])

const mediaItems = computed(() => {
  return props.portfolio.media_items || []
})

const getYouTubeEmbedUrl = (url) => {
  // Extract video ID from YouTube URL
  const videoId = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/)
  if (videoId) {
    return `https://www.youtube.com/embed/${videoId[1]}?autoplay=1&rel=0`
  }
  return url
}

const getOperatorInitials = (name) => {
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
}
</script>

<style scoped>
.portfolio-viewer {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: 40;
}
</style>