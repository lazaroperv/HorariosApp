import React, { useState, useEffect } from 'react';
import { View, TextInput, Button, StyleSheet, Alert } from 'react-native';
import { updateHorario } from '../api';

const EditHorario = ({ route, navigation }) => {
  const { horario } = route.params;
  const [dia, setDia] = useState(horario.dia);
  const [horaInicio, setHoraInicio] = useState(horario.hora_inicio);
  const [horaFin, setHoraFin] = useState(horario.hora_fin);
  const [materia, setMateria] = useState(horario.materia);
  const [profesor, setProfesor] = useState(horario.profesor);

  const handleSubmit = async () => {
    try {
      await updateHorario(horario.id, {
        dia,
        hora_inicio: horaInicio,
        hora_fin: horaFin,
        materia,
        profesor
      });
      Alert.alert('Éxito', 'Horario actualizado correctamente');
      navigation.goBack();
    } catch (error) {
      console.error('Error al actualizar horario:', error);
      Alert.alert('Error', 'No se pudo actualizar el horario');
    }
  };

  return (
    <View style={styles.container}>
      <TextInput
        style={styles.input}
        placeholder="Día"
        value={dia}
        onChangeText={setDia}
      />
      <TextInput
        style={styles.input}
        placeholder="Hora de inicio"
        value={horaInicio}
        onChangeText={setHoraInicio}
      />
      <TextInput
        style={styles.input}
        placeholder="Hora de fin"
        value={horaFin}
        onChangeText={setHoraFin}
      />
      <TextInput
        style={styles.input}
        placeholder="Materia"
        value={materia}
        onChangeText={setMateria}
      />
      <TextInput
        style={styles.input}
        placeholder="Profesor"
        value={profesor}
        onChangeText={setProfesor}
      />
      <Button title="Actualizar Horario" onPress={handleSubmit} />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
  },
  input: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginBottom: 10,
    paddingHorizontal: 10,
  },
});

export default EditHorario;





// import React, { useState, useEffect } from 'react';
// import { View, TextInput, Button, StyleSheet } from 'react-native';
// import { getHorario, updateHorario } from '../api';

// const EditHorario = ({ route, navigation }) => {
//   const { id } = route.params;
//   const [dia, setDia] = useState('');
//   const [horaInicio, setHoraInicio] = useState('');
//   const [horaFin, setHoraFin] = useState('');
//   const [materia, setMateria] = useState('');
//   const [profesor, setProfesor] = useState('');

//   useEffect(() => {
//     fetchHorario();
//   }, []);

//   const fetchHorario = async () => {
//     try {
//       const response = await getHorario(id);
//       const horario = response.data;
//       setDia(horario.dia);
//       setHoraInicio(horario.hora_inicio);
//       setHoraFin(horario.hora_fin);
//       setDescripcion(horario.descripcion);
//     } catch (error) {
//       console.error('Error al obtener horario:', error);
//     }
//   };

//   const handleSubmit = async () => {
//     try {
//       await updateHorario(id, {
//         dia,
//         hora_inicio: horaInicio,
//         hora_fin: horaFin,
//         materia: materia,
//         profesor: profesor
//       });
//       navigation.goBack();
//     } catch (error) {
//       console.error('Error al actualizar horario:', error);
//     }
//   };

//   return (
//     <View style={styles.container}>
//       <TextInput
//         style={styles.input}
//         placeholder="Día"
//         value={dia}
//         onChangeText={setDia}
//       />
//       <TextInput
//         style={styles.input}
//         placeholder="Hora de inicio"
//         value={horaInicio}
//         onChangeText={setHoraInicio}
//       />
//       <TextInput
//         style={styles.input}
//         placeholder="Hora de fin"
//         value={horaFin}
//         onChangeText={setHoraFin}
//       />
//       <TextInput
//         style={styles.input}
//         placeholder="materia"
//         value={materia}
//         onChangeText={setMateria}
//       />
//       <TextInput
//         style={styles.input}
//         placeholder="profesor"
//         value={profesor}
//         onChangeText={setProfesor}
//       />
//       <Button title="Actualizar Horario" onPress={handleSubmit} />
//     </View>
//   );
// };

// const styles = StyleSheet.create({
//   container: {
//     flex: 1,
//     padding: 20,
//   },
//   input: {
//     height: 40,
//     borderColor: 'gray',
//     borderWidth: 1,
//     marginBottom: 10,
//     paddingHorizontal: 10,
//   },
// });

// export default EditHorario;

