import { createApp } from 'vue'
import './styly.css'
import App from './App.vue'
import { createClient } from '@supabase/supabase-js'

const supabaseUrl = 'https://uwzifuvqhkqzribkfptt.supabase.co'
const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InV3emlmdXZxaGtxenJpYmtmcHR0Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTgyMjM3NDEsImV4cCI6MjA3Mzc5OTc0MX0.DQoo0WF0rkL02zQ-vA2l-mtwQKxnC3hSXrhPUVPs3NQ'
export const supabase = createClient(supabaseUrl, supabaseKey)

createApp(App).mount('#app')