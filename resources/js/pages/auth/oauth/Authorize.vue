<!-- resources/js/Pages/Auth/OAuth/Authorize.vue -->
<template>
    <div style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:16px;">
        <div style="max-width:560px;width:100%;">
            <h1 style="margin:0 0 8px 0;">Authorize “{{ client.name }}”</h1>
            <p style="margin:0 0 16px 0;">Signed in as: {{ user.email }}</p>

            <div v-if="scopes.length" style="margin-bottom:16px;">
                <strong>Requested permissions</strong>
                <div v-for="s in scopes" :key="s.id" style="margin-top:6px;">
                    <label>
                        <input type="checkbox" v-model="selectedScopes" :value="s.id" />
                        <span style="margin-left:6px;"><b>{{ s.id }}</b> — {{ s.description }}</span>
                    </label>
                </div>
            </div>

            <!-- APPROVE: native POST to /oauth/authorize -->
            <form ref="approveForm" method="POST" action="/oauth/authorize">
                <input type="hidden" name="_token" :value="usePage().props.csrf_token" />
                <input type="hidden" name="state" :value="request.state" />
                <input type="hidden" name="client_id" :value="client.id" />
                <input type="hidden" name="auth_token" :value="authToken" />
                <!-- Optional: pass selected scopes -->
                <input v-for="s in selectedScopes" :key="s" type="hidden" name="scopes[]" :value="s" />
                <button type="submit" :disabled="submitting" @click.prevent="approve">Approve</button>
            </form>

            <!-- DENY: native DELETE to /oauth/authorize -->
            <form ref="denyForm" method="POST" action="/oauth/authorize" style="margin-top:8px;">
                <input type="hidden" name="_token" :value="usePage().props.csrf_token" />
                <input type="hidden" name="_method" value="DELETE" />
                <input type="hidden" name="state" :value="request.state" />
                <input type="hidden" name="client_id" :value="client.id" />
                <input type="hidden" name="auth_token" :value="authToken" />
                <button type="submit" :disabled="submitting" @click.prevent="deny">Deny</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    request: Object,
    authToken: String,
    client: Object,
    user: Object,
    scopes: { type: Array, default: () => [] }, // [{ id, description }]
})

// Guard against double-submit
const submitting = ref(false)

const selectedScopes = ref(props.scopes.map(s => s.id))
const approveForm = ref(null)
const denyForm = ref(null)

// Get CSRF for native forms (no Blade layout)
const csrf = ref('')
onMounted(() => {
    // Option A: meta tag (recommended). Add <meta name="csrf-token" content="{{ csrf_token() }}"> once in your base HTML.
    csrf.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''

    // Option B (fallback): read it from the XSRF-TOKEN cookie
    if (!csrf.value) {
        const m = document.cookie.match(/(?:^|; )XSRF-TOKEN=([^;]+)/)
        if (m) csrf.value = decodeURIComponent(m[1])
    }
})

function approve () {
    if (submitting.value) return
    submitting.value = true
    approveForm.value?.submit() // full-page navigation → no CORS
}

function deny () {
    if (submitting.value) return
    submitting.value = true
    denyForm.value?.submit() // full-page navigation → no CORS
}
</script>
