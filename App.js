import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { StyleSheet, View, TouchableOpacity, Text } from 'react-native';
import { StatusBar } from 'expo-status-bar';
import './global.css';

import HorariosList from './src/components/HorariosList';
import AddHorario from './src/components/AddHorario';
import EditHorario from './src/components/EditHorario';


const Stack = createStackNavigator();

function HomeScreen({ navigation }) {
  return (
    <View style={styles.container} className="">
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('HorariosList')}
      >
        <Text style={styles.buttonText}>Ver Horarios</Text>
      </TouchableOpacity>
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('AddHorario')}
      >
        <Text style={styles.buttonText}>Agregar Horario</Text>
      </TouchableOpacity>
      <TouchableOpacity
        style={styles.button}
        onPress={() => navigation.navigate('EditHorario', { id: null })}
      >
        <Text style={styles.buttonText}>Editar Horario</Text>
      </TouchableOpacity>
      <StatusBar style="auto" />
    </View>
  );
}

export default function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home">
        <Stack.Screen name="Home" component={HomeScreen} options={{ title: 'Inicio' }} />
        <Stack.Screen name="HorariosList" component={HorariosList} options={{ title: 'Lista de Horarios' }} />
        <Stack.Screen name="AddHorario" component={AddHorario} options={{ title: 'Agregar Horario' }} />
        <Stack.Screen name="EditHorario" component={EditHorario} options={{ title: 'Editar Horario' }} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#fff',
    alignItems: 'center',
    justifyContent: 'center',
  },
  button: {
    backgroundColor: '#007AFF',
    padding: 15,
    borderRadius: 5,
    margin: 10,
    width: 200,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
    fontWeight: 'bold',
  },
});
