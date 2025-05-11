import { startStimulusApp } from '@symfony/stimulus-bundle';
import ChartController from '@symfony/ux-chartjs';
import '@symfony/ux-autocomplete';


const app = startStimulusApp();
app.register('chart', ChartController);
console.log('Stimulus ChartController registered');

