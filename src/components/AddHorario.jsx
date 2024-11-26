import React, { useState } from 'react';
import { View, TextInput, Button, StyleSheet } from 'react-native';
import { addHorario } from '../api';

const AddHorario = ({ navigation }) => {
  const [dia, setDia] = useState('');
  const [horaInicio, setHoraInicio] = useState('');
  const [horaFin, setHoraFin] = useState('');
  const [materia, setMateria] = useState('');
  const [profesor, setProfesor] = useState('');

  const handleSubmit = async () => {
    try {
      await addHorario({
        dia,
        hora_inicio: horaInicio,
        hora_fin: horaFin,
        materia: materia,
        profesor: profesor
      });
      navigation.goBack();
    } catch (error) {
      console.error('Error al agregar horario:', error);
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
        placeholder="materia"
        value={materia}
        onChangeText={setMateria}
      />
      <TextInput
        style={styles.input}
        placeholder="profesor"
        value={profesor}
        onChangeText={setProfesor}
      />
      <Button title="Agregar Horario" onPress={handleSubmit} />
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

export default AddHorario;
