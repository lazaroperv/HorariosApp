import axios from 'axios';

// const API_URL = 'http://192.168.1.40/horarios_api/config.php';
// const API_URL = 'http://192.168.249.232/prueba/getData.php';
 const API_URL = 'https://mayola.net.ar/prueba/getData.php';
 const APISEND_URL = 'https://mayola.net.ar/prueba/setData.php';

export const getHorarios = async () => {
    try {
      const response = await axios.get(API_URL);
      return response.data;
    } catch (error) {
      console.error('Error detallado:', error.response ? error.response.data : error.message);
      throw error;
    }
  };
  
  export const addHorario = async (horario) => {
    try {
      const response = await axios.post(APISEND_URL, horario);
      return response.data;
    } catch (error) {
      console.error('Error detallado:', error.response ? error.response.data : error.message);
      throw error;
    }
  };
  
