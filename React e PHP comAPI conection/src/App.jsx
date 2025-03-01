import { BrowserRouter, Routes, Route} from "react-router-dom";
import React, { useState } from 'react';
import Index from "./pages/Index";
import List from "./pages/List";
import Edit from "./pages/Edit";
import Create from "./pages/SignUp";
import './App.css';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Index />} />
        <Route path="/Dashboard" element={<List />} />
        <Route path="/Profile" element={<Edit />} />
        <Route path="/SignUp" element={<Create />} />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
