<template>
  <div class="job-card liquid-glass p-6 hover:scale-[1.02] transition-all duration-300 cursor-pointer" @click="$emit('click', job)">
    <!-- Featured Badge -->
    <div v-if="job.is_featured" class="absolute -top-2 -right-2 z-10">
      <div class="bg-gradient-to-r from-accent to-accent/80 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
        </svg>
        Wyróżnione
      </div>
    </div>
    
    <!-- Job Header -->
    <div class="flex items-start justify-between mb-4">
      <div class="flex-1">
        <h3 class="text-primary font-semibold text-lg mb-2 line-clamp-2">{{ job.title }}</h3>
        <div class="flex items-center text-secondary text-sm mb-2">
          <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          {{ job.location }}
        </div>
      </div>
      
      <!-- Status Badge -->
      <div class="ml-4">
        <span 
          class="px-3 py-1 rounded-full text-xs font-medium"
          :class="getStatusClass(job.status)"
        >
          {{ getStatusText(job.status) }}
        </span>
      </div>
    </div>
    
    <!-- Job Description -->
    <p class="text-secondary text-sm mb-4 line-clamp-3">{{ job.description }}</p>
    
    <!-- Job Details -->
    <div class="flex items-center justify-between">
      <!-- Budget -->
      <div class="flex items-center">
        <svg class="w-4 h-4 mr-1 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
        </svg>
        <span class="text-primary font-semibold">{{ formatBudget(job.budget) }}</span>
      </div>
      
      <!-- Posted Date -->
      <div class="flex items-center text-secondary text-sm">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ formatDate(job.created_at) }}
      </div>
    </div>
    
    <!-- Client Info -->
    <div class="flex items-center mt-4 pt-4 border-t border-glass-border">
      <div class="w-8 h-8 bg-gradient-to-br from-dark-accent to-dark-accent/70 rounded-full flex items-center justify-center">
        <span class="text-white text-xs font-semibold">{{ getClientInitials(job.client?.name) }}</span>
      </div>
      <div class="ml-3">
        <p class="text-primary text-sm font-medium">{{ job.client?.name || 'Klient' }}</p>
        <p class="text-secondary text-xs">{{ getClientRating(job.client) }}</p>
      </div>
    </div>
    
    <!-- Proposals Count (if job is open) -->
    <div v-if="job.status === 'open' && job.proposals_count !== undefined" class="mt-3 text-center">
      <span class="text-secondary text-xs">
        {{ job.proposals_count }} {{ job.proposals_count === 1 ? 'oferta' : 'ofert' }}
      </span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  job: {
    type: Object,
    required: true
  }
})

defineEmits(['click'])

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
  if (diffDays < 30) return `${Math.floor(diffDays / 7)} tygodni temu`
  
  return jobDate.toLocaleDateString('pl-PL', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
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
</script>

<style scoped>
.job-card {
  position: relative;
  border-radius: 16px;
  transition: all 0.3s ease;
}

.job-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>