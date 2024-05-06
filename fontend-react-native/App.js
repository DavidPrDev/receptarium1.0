import React, { useEffect, useState } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { createDrawerNavigator, DrawerContentScrollView, DrawerItemList } from '@react-navigation/drawer';
import { onAuthStateChanged } from '@react-native-firebase/auth';
import { FIREBASE_AUTH } from './firebaseConfig';
import AuthScreen from './src/screens/AuthScren';
import Dashboard from './src/screens/Dashboard';
import LoginRegister from './src/screens/LoginRegister';
import BottomBarNavigator from './src/components/BottomBarNavigator';
import { View, Text, TouchableOpacity,StyleSheet,Image, StatusBar } from 'react-native';
import LogOut from './src/services/LogOut';

const Stack = createNativeStackNavigator();
const Drawer = createDrawerNavigator();

const CustomHeaderTitle = () => {
  return (
    <View style={styles.titlecontainer}>
      <Text style={styles.title}>Receptarium</Text>
      <Image
       source={require('./assets/icon.png')} 
       style={styles.iconTitle}
       />
    </View>
  );
};
const handleLogout = () => {
  LogOut();
};
const CustomDrawerContent = (props) => {
  return (
    <DrawerContentScrollView {...props}>
      
      <View style={{ flex: 1 }}>
        <DrawerItemList {...props} />
        <View style={{ flexDirection: 'row', marginLeft:17, marginTop: 10 }}>
          <TouchableOpacity style={styles.btnCerrar} onPress={() => handleLogout()}>
            <Text>Cerrar Session</Text>
          </TouchableOpacity>
        </View>
      </View>
    </DrawerContentScrollView>
  );
};

const DrawerNavigator = () => {
  return (
    <Drawer.Navigator
      screenOptions={{
        headerShown: true,
        headerTitle: () => <CustomHeaderTitle />,
        headerStyle: {
          backgroundColor: '#F582AE',
          height: 85,
          
        },
        drawerContentOptions: {
          activeTintColor: 'red', 
          inactiveTintColor: 'blue',
        },
        headerTintColor: '#FFFFFF'
        
      }}
      drawerType="back"
      drawerContent={props => <CustomDrawerContent {...props} />}
    >
      <Drawer.Screen name="Mis recetas" component={BottomBarNavigator} />
      <Drawer.Screen name="Politica de privacidad" component={Dashboard} />
    </Drawer.Navigator>
  );
};



export default function App() {
  const [user, setUser] = useState(null);

  useEffect(() => {
    onAuthStateChanged(FIREBASE_AUTH, (user) => {
      setUser(user);
    });
  }, []);
  

  return (
    <>
     <StatusBar backgroundColor="#F582AE" barStyle="light-content" />
    <NavigationContainer>
      <Stack.Navigator>
        {user ? (
          <>
            <Stack.Screen
              name="Drawer"
              component={DrawerNavigator}
              options={{ headerShown: false }}
            />
          </>
        ) : (
          <>
            <Stack.Screen
              name="Auth"
              component={AuthScreen}
              options={{
                headerShown: false,
                cardStyle: { backgroundColor: '#f582ae32' },
              }}
            />
            <Stack.Screen
              name="LoginRegister"
              component={LoginRegister}
              options={{
                headerShown: false,
                cardStyle: { backgroundColor: '#f582ae32' },
              }}
            />
          </>
        )}
      </Stack.Navigator>
    </NavigationContainer>
    </>
  );
}

const styles = StyleSheet.create({
  btnCerrar:{
    backgroundColor:'red',
    width:'40%',
    paddingLeft:7,
    height:30,
    justifyContent:'center',
    borderRadius:7,
  },
  title:{
    color:'white',
    fontSize:30
  },
  titlecontainer:{
     flexDirection: 'row',
      alignItems: 'center',
    marginLeft:20
    },
    iconTitle:{
      width:40,
      height:40,
      borderRadius:40,
      marginLeft:5
    }
});