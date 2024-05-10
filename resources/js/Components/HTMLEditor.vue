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
    <div class="tiptap-editor p-1" v-if="editor">
        <section class="p-2">
            <button 
                @click="editor.chain().focus().toggleBold().run()" 
                :disabled="!editor.can().chain().focus().toggleBold().run()" 
                :class="[ editor.isActive('bold') ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            bold
            </button>
            <button 
                @click="editor.chain().focus().toggleItalic().run()" 
                :disabled="!editor.can().chain().focus().toggleItalic().run()" 
                :class="[ editor.isActive('italic') ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            italic
            </button>
            <button 
                @click="editor.chain().focus().toggleUnderline().run()" 
                :disabled="!editor.can().chain().focus().toggleUnderline().run()" 
                :class="[ editor.isActive('underline') ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            underline
            </button>
            <button 
                @click="editor.chain().focus().toggleStrike().run()" 
                :disabled="!editor.can().chain().focus().toggleStrike().run()" 
                :class="[ editor.isActive('strike') ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            strike
            </button>
            <button 
                @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" 
                :class="[ editor.isActive('heading', { level: 1 }) ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            h1
            </button>
            <button 
                @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" 
                :class="[ editor.isActive('heading', { level: 2 }) ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            h2
            </button>
            <button 
                @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" 
                :class="[ editor.isActive('heading', { level: 3 }) ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            h3
            </button>
            <button 
                @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" 
                :class="[ editor.isActive('heading', { level: 4 }) ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            h4
            </button>
            <button 
                @click="editor.chain().focus().toggleHeading({ level: 5 }).run()"
                :class="[ editor.isActive('heading', { level: 5 }) ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            h5
            </button>
            <button 
                @click="editor.chain().focus().toggleHeading({ level: 6 }).run()" 
                :class="[ editor.isActive('heading', { level: 6 }) ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            h6
            </button>
            <button 
                @click="editor.chain().focus().toggleBulletList().run()" 
                :class="[ editor.isActive('bulletList') ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            bullet list
            </button>
            <button 
                @click="editor.chain().focus().toggleOrderedList().run()" 
                :class="[ editor.isActive('orderedList') ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            ordered list
            </button>
            <button 
                @click="editor.chain().focus().toggleBlockquote().run()" 
                :class="[ editor.isActive('blockquote') ? 'bg-secondary text-light' : 'bg-secondary-subtle' ]" 
                class="me-2 border-secondary"
                type="button"
            >
            blockquote
            </button>
            <button 
                @click="editor.chain().focus().setHorizontalRule().run()" 
                class="bg-secondary-subtle me-2 border-secondary"
                type="button"
            >
            horizontal rule
            </button>
            <button 
                @click="editor.chain().focus().setHardBreak().run()" 
                class="bg-secondary-subtle me-2 border-secondary"
                type="button"
            >
            hard break
            </button>
        </section>
        <EditorContent 
            class="mt-2 p-2 border-top"
            :editor="editor" 
        />
    </div>
</template>



<style lang="scss">
    .ProseMirror:focus {
        outline: none;
    }

    .tiptap-editor {
        border: 1px solid #DEE2E6;
        border-radius: 7px;
    }

    .is-active {
        background-color: red;
        color: blue;
    }
    .tiptap {
        > * + * {
            margin: 0.25em 0;
        }

        blockquote {
            padding-left: 1rem;
            border-left: 2px solid rgba(#0D0D0D, 0.5);
        }

        hr {
            border: none;
            border-top: 2px solid rgba(#0D0D0D, 0.5);
            margin: 2rem 0.5rem;
        }
    }
</style>