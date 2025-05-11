import { startStimulusApp } from '@symfony/stimulus-bundle';
import ChartController from '@symfony/ux-chartjs';

const app = startStimulusApp();
app.register('chart', ChartController);
console.log('Stimulus ChartController registered'); // Ajoute ce log pour vérifier si le contrôleur est bien enregistré

