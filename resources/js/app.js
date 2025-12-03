import './bootstrap';
import { createApp } from 'vue';

// Import Vue components
import ExampleComponent from './components/ExampleComponent.vue';
import PortfolioCard from './components/PortfolioCard.vue';
import TikTokScrollContainer from './components/TikTokScrollContainer.vue';
import PortfolioViewer from './components/PortfolioViewer.vue';
import PortfolioTikTokViewer from './components/PortfolioTikTokViewer.vue';
import JobTikTokViewer from './components/JobTikTokViewer.vue';
import JobCard from './components/JobCard.vue';
import NavigationBar from './components/NavigationBar.vue';

// Create Vue app
const app = createApp({});

// Register components
app.component('example-component', ExampleComponent);
app.component('portfolio-card', PortfolioCard);
app.component('tik-tok-scroll-container', TikTokScrollContainer);
app.component('portfolio-viewer', PortfolioViewer);
app.component('portfolio-tiktok-viewer', PortfolioTikTokViewer)
    .component('job-tiktok-viewer', JobTikTokViewer);
app.component('job-card', JobCard);
app.component('navigation-bar', NavigationBar);

// Mount the app
app.mount('#app');