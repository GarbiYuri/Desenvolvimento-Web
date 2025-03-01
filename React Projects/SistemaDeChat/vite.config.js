import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react-swc'

// https://vite.dev/config/

export default defineConfig({
  plugins: [react()],
  server: {
    host: '0.0.0.0', // Para permitir que outros dispositivos acessem
    port: 5173,      // Porta padrão ou escolha outra disponível
    strictPort: true, // Garante que a porta não mude
    hmr: {
      host: '25.0.156.182', // Substitua pelo IP do Hamachi
      port: 5173,       // Use a mesma porta configurada acima
    }
  },
});