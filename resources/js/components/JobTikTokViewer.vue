<template>
  <div class="job-tiktok-viewer relative w-full h-screen overflow-hidden">
    <!-- Main scroll container -->
    <div 
      ref="scrollContainer"
      class="h-full overflow-y-auto snap-y snap-mandatory scrollbar-hide"
      @scroll="handleScroll"
    >
      <div 
        v-for="(job, index) in jobs" 
        :key="job.id"
        class="relative w-full h-screen snap-start flex items-center justify-center"
        :class="{ 'active': currentIndex === index }"
      >
        <!-- Background with gradient overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-dark-surface via-dark-surface/95 to-dark-surface/90"></div>
        
        <!-- Job Content -->
        <div class="relative z-10 w-full max-w-4xl mx-auto px-6 flex items-center justify-center min-h-screen">
          <div class="liquid-glass rounded-liquid p-8 w-full max-w-2xl">
            <!-- Featured Badge -->
            <div v-if="job.is_featured" class="absolute -top-3 -right-3 z-20">
              <div class="bg-gradient-to-r from-accent to-accent/80 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Wyróżnione
              </div>
            </div>

            <!-- Job Header -->
            <div class="text-center mb-8">
              <h1 class="text-3xl md:text-4xl font-bold text-primary mb-4">{{ job.title }}</h1>
              
              <!-- Location and Budget -->
              <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6">
                <div class="flex items-center text-secondary">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                  {{ job.location }}
                </div>
                
                <div class="flex items-center text-accent font-bold text-xl">
                  <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                  </svg>
                  {{ formatBudget(job.budget) }}
                </div>
              </div>

              <!-- Status Badge -->
              <div class="flex justify-center mb-6">
                <span 
                  class="px-4 py-2 rounded-full text-sm font-medium"
                  :class="getStatusClass(job.status)"
                >
                  {{ getStatusText(job.status) }}
                </span>
              </div>
            </div>

            <!-- Job Description -->
            <div class="mb-8">
              <p class="text-secondary text-lg leading-relaxed text-center">{{ job.description }}</p>
            </div>

            <!-- Client Info -->
            <div class="flex items-center justify-center mb-8">
              <div class="flex items-center liquid-glass rounded-full px-6 py-3">
                <div class="w-12 h-12 bg-gradient-to-br from-accent to-accent/70 rounded-full flex items-center justify-center mr-4">
                  <span class="text-white font-semibold">{{ getClientInitials(job.client?.name) }}</span>
                </div>
                <div>
                  <p class="text-primary font-semibold">{{ job.client?.name || 'Klient' }}</p>
                  <p class="text-secondary text-sm">{{ getClientRating(job.client) }}</p>
                </div>
              </div>
            </div>

            <!-- Job Stats -->
            <div class="grid grid-cols-2 gap-4 mb-8">
              <div class="text-center">
                <div class="text-2xl font-bold text-primary">{{ job.proposals_count || 0 }}</div>
                <div class="text-secondary text-sm">{{ (job.proposals_count || 0) === 1 ? 'Oferta' : 'Ofert' }}</div>
              </div>
              <div class="text-center">
                <div class="text-2xl font-bold text-primary">{{ formatDate(job.created_at) }}</div>
                <div class="text-secondary text-sm">Opublikowano</div>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
              <button 
                @click="viewJob(job)"
                class="flex-1 btn-primary py-3 text-lg font-semibold"
              >
                Zobacz Szczegóły
              </button>
              <button 
                v-if="canApply(job)"
                @click="applyToJob(job)"
                class="flex-1 btn-secondary py-3 text-lg font-semibold"
              >
                Złóż Ofertę
              </button>
            </div>
          </div>
        </div>

        <!-- Side Navigation Dots -->
        <div class="absolute right-6 top-1/2 transform -translate-y-1/2 z-20">
          <div class="flex flex-col space-y-3">
            <div 
              v-for="(_, dotIndex) in jobs" 
              :key="dotIndex"
              class="w-3 h-3 rounded-full cursor-pointer transition-all duration-300"
              :class="currentIndex === dotIndex ? 'bg-accent scale-125' : 'bg-white/30 hover:bg-white/50'"
              @click="scrollToJob(dotIndex)"
            ></div>
          </div>
        </div>

        <!-- Scroll Progress -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20">
          <div class="flex items-center space-x-2 text-white/70 text-sm">
            <span>{{ currentIndex + 1 }}</span>
            <div class="w-16 h-1 bg-white/20 rounded-full overflow-hidden">
              <div 
                class="h-full bg-accent transition-all duration-300"
                :style="{ width: `${((currentIndex + 1) / jobs.length) * 100}%` }"
              ></div>
            </div>
            <span>{{ jobs.length }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Arrows -->
    <button 
      v-if="currentIndex > 0"
      @click="scrollToPrevious"
      class="absolute left-6 top-1/2 transform -translate-y-1/2 z-20 p-3 bg-black/20 backdrop-blur-sm rounded-full text-white hover:bg-black/30 transition-colors"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
      </svg>
    </button>

    <button 
      v-if="currentIndex < jobs.length - 1"
      @click="scrollToNext"
      class="absolute left-6 bottom-20 z-20 p-3 bg-black/20 backdrop-blur-sm rounded-full text-white hover:bg-black/30 transition-colors"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
      </svg>
    </button>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'

const props = defineProps({
  jobs: {
    type: Array,
    required: true
  },
  user: {
    type: Object,
    default: null
  }
})

const emit = defineEmits(['view-job', 'apply-job'])

const scrollContainer = ref(null)
const currentIndex = ref(0)
const isScrolling = ref(false)

// Auto-scroll functionality
const autoScrollInterval = ref(null)
const autoScrollDelay = 8000 // 8 seconds

const startAutoScroll = () => {
  if (props.jobs.length <= 1) return
  
  autoScrollInterval.value = setInterval(() => {
    if (!isScrolling.value) {
      scrollToNext()
    }
  }, autoScrollDelay)
}

const stopAutoScroll = () => {
  if (autoScrollInterval.value) {
    clearInterval(autoScrollInterval.value)
    autoScrollInterval.value = null
  }
}

const handleScroll = () => {
  if (!scrollContainer.value) return
  
  const container = scrollContainer.value
  const scrollTop = container.scrollTop
  const itemHeight = container.clientHeight
  const newIndex = Math.round(scrollTop / itemHeight)
  
  if (newIndex !== currentIndex.value && newIndex >= 0 && newIndex < props.jobs.length) {
    currentIndex.value = newIndex
  }
}

const scrollToJob = (index) => {
  if (!scrollContainer.value || index < 0 || index >= props.jobs.length) return
  
  isScrolling.value = true
  const container = scrollContainer.value
  const targetScroll = index * container.clientHeight
  
  container.scrollTo({
    top: targetScroll,
    behavior: 'smooth'
  })
  
  setTimeout(() => {
    isScrolling.value = false
  }, 500)
}

const scrollToNext = () => {
  if (currentIndex.value < props.jobs.length - 1) {
    scrollToJob(currentIndex.value + 1)
  } else {
    scrollToJob(0) // Loop back to first
  }
}

const scrollToPrevious = () => {
  if (currentIndex.value > 0) {
    scrollToJob(currentIndex.value - 1)
  }
}

// Keyboard navigation
const handleKeydown = (event) => {
  switch (event.key) {
    case 'ArrowUp':
      event.preventDefault()
      scrollToPrevious()
      break
    case 'ArrowDown':
      event.preventDefault()
      scrollToNext()
      break
    case ' ':
      event.preventDefault()
      if (autoScrollInterval.value) {
        stopAutoScroll()
      } else {
        startAutoScroll()
      }
      break
  }
}

// Job actions
const viewJob = (job) => {
  emit('view-job', job)
}

const applyToJob = (job) => {
  emit('apply-job', job)
}

const canApply = (job) => {
  return props.user && 
         props.user.role === 'operator' && 
         job.status === 'open' &&
         job.client_id !== props.user.id
}

// Utility functions
const getStatusClass = (status) => {
  const classes = {
    'open': 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
    'in_progress': 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400',
    'completed': 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400',
    'closed': 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400'
  }
  return classes[status] || classes['open']
}

const getStatusText = (status) => {
  const texts = {
    'open': 'Otwarte',
    'in_progress': 'W trakcie',
    'completed': 'Zakończone',
    'closed': 'Zamknięte'
  }
  return texts[status] || 'Nieznany'
}

const formatBudget = (budget) => {
  if (!budget) return 'Do negocjacji'
  return new Intl.NumberFormat('pl-PL', {
    style: 'currency',
    currency: 'PLN',
    minimumFractionDigits: 0
  }).format(budget)
}

const formatDate = (date) => {
  if (!date) return ''
  const now = new Date()
  const jobDate = new Date(date)
  const diffTime = Math.abs(now - jobDate)
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  
  if (diffDays === 1) return '1 dzień temu'
  if (diffDays < 7) return `${diffDays} dni temu`
  if (diffDays < 30) return `${Math.floor(diffDays / 7)} tyg. temu`
  
  return jobDate.toLocaleDateString('pl-PL', {
    day: 'numeric',
    month: 'short'
  })
}

const getClientInitials = (name) => {
  if (!name) return 'K'
  return name.split(' ').map(word => word[0]).join('').toUpperCase().slice(0, 2)
}

const getClientRating = (client) => {
  if (!client || !client.average_rating) return 'Nowy klient'
  const rating = parseFloat(client.average_rating)
  const stars = '★'.repeat(Math.floor(rating)) + '☆'.repeat(5 - Math.floor(rating))
  return `${stars} (${rating.toFixed(1)})`
}

onMounted(() => {
  document.addEventListener('keydown', handleKeydown)
  startAutoScroll()
})

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown)
  stopAutoScroll()
})
</script>

<style scoped>
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

.liquid-glass {
  background: rgba(42, 45, 50, 0.6);
  backdrop-filter: blur(24px);
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.hover-glow:hover {
  box-shadow: 0 0 30px rgba(138, 180, 248, 0.3);
}

.btn-primary {
  @apply bg-accent text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-600 transition-colors;
}

.btn-secondary {
  @apply bg-transparent border border-accent text-accent px-6 py-2 rounded-lg font-semibold hover:bg-accent hover:text-white transition-colors;
}

.text-primary {
  @apply text-gray-100;
}

.text-secondary {
  @apply text-gray-300;
}

.text-accent {
  @apply text-blue-400;
}

.bg-accent {
  @apply bg-blue-500;
}

.dark-surface {
  background-color: #131314;
}
</style>