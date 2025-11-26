import './bootstrap';
import {createApp} from "vue";
import Icons from './icons/Icons.vue'
import Badge from './components/Badge.vue'
import Dashboard from "./components/dashboard/Dashboard.vue";
import RepositoryList from "./components/dashboard/RepositoryList.vue";
import RepositoryView from "./components/dashboard/RepositoryView.vue";

const app = createApp({});

app.component('icon', Icons)
app.component('rs-badge', Badge)

app.component('rs-dashboard', Dashboard)
app.component('rs-repository-list', RepositoryList)
app.component('rs-repository-view', RepositoryView)

app.mount('#app');
