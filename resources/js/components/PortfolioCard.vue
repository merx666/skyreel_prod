<template>
  <div class="portfolio-card liquid-glass hover-glow cursor-pointer" @click="$emit('click')">
    <div class="relative overflow-hidden rounded-t-liquid">
      <!-- Video Thumbnail -->
      <div v-if="portfolio.featured_media?.type === 'video'" class="relative">
        <img 
          :src="portfolio.featured_media.thumbnail_url" 
          :alt="portfolio.featured_media.title"
          class="w-full h-64 object-cover"
        />
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="w-16 h-16 bg-black bg-opacity-50 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
              <path d="M8 5v14l11-7z"/>
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Image -->
      <img 
        v-else-if="portfolio.featured_media?.type === 'image'"
        :src="portfolio.featured_media.source_url" 
        :alt="portfolio.featured_media.title"
        class="w-full h-64 object-cover"
      />
      
      <!-- Placeholder -->
      <div v-else class="w-full h-64 bg-gradient-to-br from-dark-accent/20 to-dark-accent/5 flex items-center justify-center">
        <svg class="w-16 h-16 text-dark-accent/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    </div>
    
    <div class="p-6">
      <!-- Operator Info -->
      <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-gradient-to-br from-dark-accent to-dark-accent/70 rounded-full flex items-center justify-center">
          <span class="text-white font-semibold text-sm">{{ operatorInitials }}</span>
        </div>
        <div class="ml-3">
          <h3 class="text-primary font-semibold">{{ portfolio.user.name }}</h3>
          <p class="text-secondary text-sm">{{ portfolio.user.profile?.location }}</p>
        </div>
      </div>
      
      <!-- Portfolio Title -->
      <h4 class="text-primary font-semibold text-lg mb-2">{{ portfolio.title }}</h4>
      
      <!-- Description -->
      <p class="text-secondary text-sm mb-4 line-clamp-2">{{ portfolio.description }}</p>
      
      <!-- Stats -->
      <div class="flex items-center justify-between text-sm">
        <span class="text-secondary">{{ portfolio.media_count }} {{ portfolio.media_count === 1 ? 'element' : 'elementów' }}</span>
        <span v-if="portfolio.user.profile?.is_featured" class="px-2 py-1 bg-dark-accent/20 text-dark-accent rounded-full text-xs font-medium">
          Wyróżniony
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  portfolio: {
    type: Object,
    required: true
  }
})

defineEmits(['click'])

const operatorInitials = computed(() => {
  const name = props.portfolio.user.name
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
})
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>