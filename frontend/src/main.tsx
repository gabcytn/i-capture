// import { StrictMode } from 'react'
import { useEffect } from "react";
import { BrowserRouter, Route, Routes } from 'react-router'
import { createRoot } from 'react-dom/client'
import App from './pages/App.tsx'
import Login from './pages/auth/Login.tsx'
import Register from './pages/auth/Register.tsx'
import NotFound from './pages/NotFound.tsx'

const Main = () => {
  useEffect(() => {
    const SERVER_URL = import.meta.env.VITE_SERVER_URL;
    localStorage.setItem("serverUrl", SERVER_URL);
  }, [])

  return (
    <BrowserRouter>
      <Routes>
        <Route path='/' element={<App />} />
        <Route path='/login' element={<Login />} />
        <Route path='/register' element={<Register />} />
        <Route path='*' element={<NotFound />} />
      </Routes>
    </BrowserRouter>
  )
}

export default Main;

createRoot(document.getElementById('root')!).render(<Main />)
