<script setup>
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import { Editor, EditorContent } from '@tiptap/vue-3'
import { ref, watch, onMounted, onBeforeUnmount, defineProps, defineEmits } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
})

const emits = defineEmits(['update:modelValue'])

const editor = ref(null)

watch(() => props.modelValue, (value) => {
    const isSame = editor.value.getHTML() === value
    
    if (isSame === false) {
        editor.value.commands.setContent(value, false)
    }
})

onMounted(() => {
    editor.value = new Editor({
        extensions: [
            StarterKit,
            Underline
        ],
        content: props.modelValue,
        onUpdate: () => {
            emits('update:modelValue', editor.value.getHTML())
        },
    })
})

onBeforeUnmount(() => {
    editor.value.destroy()
})
</script>

<template>
    <div class="tiptap-editor" v-if="editor">
        <button 
            @click="editor.chain().focus().toggleBold().run()" 
            :disabled="!editor.can().chain().focus().toggleBold().run()" 
            :class="{ 'is-active': editor.isActive('bold') }" 
            type="button"
        >
        bold
        </button>
        <button 
            @click="editor.chain().focus().toggleItalic().run()" 
            :disabled="!editor.can().chain().focus().toggleItalic().run()" 
            :class="{ 'is-active': 
            editor.isActive('italic') }"
            type="button"
        >
        italic
        </button>
        <button 
            @click="editor.chain().focus().toggleUnderline().run()" 
            :disabled="!editor.can().chain().focus().toggleUnderline().run()" 
            :class="{ 'is-active': 
            editor.isActive('underline') }"
            type="button"
        >
        underline
        </button>
        <button 
            @click="editor.chain().focus().toggleStrike().run()" 
            :disabled="!editor.can().chain().focus().toggleStrike().run()" 
            :class="{ 'is-active': editor.isActive('strike') }"
            type="button"
        >
        strike
        </button>
        <button 
            @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" 
            :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }" 
            type="button"
        >
        h1
        </button>
        <button 
            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" 
            :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }" 
            type="button"
        >
        h2
        </button>
        <button 
            @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" 
            :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }" 
            type="button"
        >
        h3
        </button>
        <button 
            @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" 
            :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }" 
            type="button"
        >
        h4
        </button>
        <button 
            @click="editor.chain().focus().toggleHeading({ level: 5 }).run()"
            :class="{ 'is-active': editor.isActive('heading', { level: 5 }) }" 
            type="button"
        >
        h5
        </button>
        <button 
            @click="editor.chain().focus().toggleHeading({ level: 6 }).run()" 
            :class="{ 'is-active': editor.isActive('heading', { level: 6 }) }" 
            type="button"
        >
        h6
        </button>
        <button 
            @click="editor.chain().focus().toggleBulletList().run()" 
            :class="{ 'is-active': editor.isActive('bulletList') }" 
            type="button"
        >
        bullet list
        </button>
        <button 
            @click="editor.chain().focus().toggleOrderedList().run()" 
            :class="{ 'is-active': editor.isActive('orderedList') }" 
            type="button"
        >
        ordered list
        </button>
        <button 
            @click="editor.chain().focus().toggleBlockquote().run()" 
            :class="{ 'is-active': editor.isActive('blockquote') }" 
            type="button"
        >
        blockquote
        </button>
        <button 
            @click="editor.chain().focus().setHorizontalRule().run()" 
            type="button"
        >
        horizontal rule
        </button>
        <button 
            @click="editor.chain().focus().setHardBreak().run()" 
            type="button"
        >
        hard break
        </button>
        <EditorContent :editor="editor" />
    </div>
</template>



<style lang="scss">
    .tiptap {
        > * + * {
            margin: 0.25em 0;
        }

        blockquote {
            padding-left: 1rem;
            border-left: 3px solid rgba(#0D0D0D, 0.5);
        }

        hr {
            border: none;
            border-top: 2px solid rgba(#0D0D0D, 0.5);
            margin: 2rem 0.5rem;
        }
    }
</style>