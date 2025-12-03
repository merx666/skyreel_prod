<template>
  <div class="tiktok-scroll-container snap-container" ref="scrollContainer">
    <div 
      v-for="(item, index) in items" 
      :key="item.id"
      class="snap-item relative"
      :class="{ 'active': currentIndex === index }"
    >
      <slot :item="item" :index="index" :isActive="currentIndex === index"></slot>
      
      <!-- Navigation Dots -->
      <div class="absolute right-4 top-1/2 transform -translate-y-1/2 flex flex-col space-y-2 z-10">
        <button
          v-for="(dot, dotIndex) in items"
          :key="dotIndex"
          @click="scrollToIndex(dotIndex)"
          class="w-2 h-2 rounded-full transition-all duration-200"
          :class="currentIndex === dotIndex ? 'bg-white' : 'bg-white/30'"
        ></button>
      </div>
      
      <!-- Scroll Indicators -->
      <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex items-center space-x-2 z-10">
        <button
          v-if="index > 0"
          @click="scrollToPrevious"
          class="p-2 bg-black/20 backdrop-blur-sm rounded-full text-white hover:bg-black/30 transition-colors"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
          </svg>
        </button>
        
        <span class="text-white text-sm bg-black/20 backdrop-blur-sm px-3 py-1 rounded-full">
          {{ currentIndex + 1 }} / {{ items.length }}
        </span>
        
        <button
          v-if="index < items.length - 1"
          @click="scrollToNext"
          class="p-2 bg-black/20 backdrop-blur-sm rounded-full text-white hover:bg-black/30 transition-colors"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'

const props = defineProps({
  items: {
    type: Array,
    required: true
  }
})

const scrollContainer = ref(null)
const currentIndex = ref(0)

let isScrolling = false
let scrollTimeout = null

const updateCurrentIndex = () => {
  if (!scrollContainer.value) return
  
  const container = scrollContainer.value
  const scrollTop = container.scrollTop
  const itemHeight = container.clientHeight
  const newIndex = Math.round(scrollTop / itemHeight)
  
  if (newIndex !== currentIndex.value && newIndex >= 0 && newIndex < props.items.length) {
    currentIndex.value = newIndex
  }
}

const scrollToIndex = (index) => {
  if (!scrollContainer.value || isScrolling) return
  
  isScrolling = true
  const container = scrollContainer.value
  const itemHeight = container.clientHeight
  
  container.scrollTo({
    top: index * itemHeight,
    behavior: 'smooth'
  })
  
  currentIndex.value = index
  
  setTimeout(() => {
    isScrolling = false
  }, 500)
}

const scrollToNext = () => {
  if (currentIndex.value < props.items.length - 1) {
    scrollToIndex(currentIndex.value + 1)
  }
}

const scrollToPrevious = () => {
  if (currentIndex.value > 0) {
    scrollToIndex(currentIndex.value - 1)
  }
}

const handleScroll = () => {
  if (isScrolling) return
  
  clearTimeout(scrollTimeout)
  scrollTimeout = setTimeout(() => {
    updateCurrentIndex()
  }, 100)
}

const handleKeydown = (event) => {
  switch (event.key) {
    case 'ArrowDown':
    case ' ':
      event.preventDefault()
      scrollToNext()
      break
    case 'ArrowUp':
      event.preventDefault()
      scrollToPrevious()
      break
  }
}

onMounted(() => {
  if (scrollContainer.value) {
    scrollContainer.value.addEventListener('scroll', handleScroll, { passive: true })
  }
  document.addEventListener('keydown', handleKeydown)
})

onUnmounted(() => {
  if (scrollContainer.value) {
    scrollContainer.value.removeEventListener('scroll', handleScroll)
  }
  document.removeEventListener('keydown', handleKeydown)
  clearTimeout(scrollTimeout)
})

defineExpose({
  scrollToIndex,
  scrollToNext,
  scrollToPrevious,
  currentIndex
})
</script>

<style scoped>
.tiktok-scroll-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  z-index: 50;
}

.snap-item {
  position: relative;
  width: 100%;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Hide scrollbar but keep functionality */
.tiktok-scroll-container::-webkit-scrollbar {
  display: none;
}

.tiktok-scroll-container {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
</style>