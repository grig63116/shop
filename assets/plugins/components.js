import Vue from 'vue';

const ComponentContext = require.context('@/components/', true, /\.vue$/i, 'lazy');
ComponentContext.keys().forEach((componentFilePath) => {
    const componentName = componentFilePath.split('/').pop().split('.')[0];
    Vue.component(componentName, () => ComponentContext(componentFilePath));
});