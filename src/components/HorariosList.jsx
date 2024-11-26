import React, { useState, useEffect } from 'react';
import { View, Text, FlatList, StyleSheet, TouchableOpacity, Alert } from 'react-native';
import { getHorarios, deleteHorario } from '../api';

const HorariosList = ({ navigation }) => {
  const [horarios, setHorarios] = useState([]);

  useEffect(() => {
    fetchHorarios();
  }, [3000]);

  const fetchHorarios = () => {
    try {
      getHorarios().then((res)=>{
        setHorarios(res);
      }).catch((error)=>{
        console.error('Error al obtener horarios:', error);
      })
    } catch (error) {
      console.error('Error al obtener horarios:', error);
    }
  };

  const handleDelete = (id) => {
    Alert.alert(
      "Eliminar Horario",
      "¿Estás seguro de que quieres eliminar este horario?",
      [
        { text: "Cancelar", style: "cancel" },
        { text: "Eliminar", onPress: () => confirmDelete(id) }
      ]
    );
  };

  const confirmDelete = async (id) => {
    try {
      await deleteHorario(id);
      fetchHorarios(); // Recargar la lista después de eliminar
    } catch (error) {
      console.error('Error al eliminar horario:', error);
    }
  };

  const renderItem = (item,i) => (
    <View key={i} style={styles.item}>
      <Text>{item.dia}</Text>
      <Text>{item.hora_inicio} - {item.hora_fin}</Text>
      <Text>{item.materia}</Text>
      <Text>{item.profesor}</Text>
      <View style={styles.buttonContainer}>
        <TouchableOpacity 
          style={styles.editButton} 
          onPress={() => navigation.navigate('EditHorario', { horario: item })}
        >
          <Text style={styles.buttonText}>Editar</Text>
        </TouchableOpacity>
        <TouchableOpacity 
          style={styles.deleteButton} 
          onPress={() => handleDelete(item.id)}
        >
          <Text style={styles.buttonText}>Eliminar</Text>
        </TouchableOpacity>
      </View>
    </View>
  );

   return (
    <View style={styles.container}>
        {horarios.map((item,i)=>{
          return renderItem(item,i)
          })}
      <TouchableOpacity 
        style={styles.addButton} 
        onPress={() => navigation.navigate('AddHorario')}
      >
        <Text style={styles.buttonText}>Agregar Horario</Text>
      </TouchableOpacity>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 10,
  },
  item: {
    backgroundColor: '#f9c2ff',
    padding: 20,
    marginVertical: 8,
    marginHorizontal: 16,
  },
  buttonContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginTop: 10,
  },
  editButton: {
    backgroundColor: '#4CAF50',
    padding: 10,
    borderRadius: 5,
  },
  deleteButton: {
    backgroundColor: '#f44336',
    padding: 10,
    borderRadius: 5,
  },
  addButton: {
    backgroundColor: '#2196F3',
    padding: 15,
    borderRadius: 5,
    alignItems: 'center',
    margin: 10,
  },
  buttonText: {
    color: 'white',
    fontWeight: 'bold',
  },
});

export default HorariosList;