export async function addMotor(motor: any) {
  const token = useCookie("auth_token");
  try {
    return await $fetch("http://localhost:8000/api/motor", {
      method: "POST",
      headers: {
        Authorization: `Bearer ${token.value}`,
      },
      body: motor,
    });
  } catch (error: any) {
    console.log(error.data.errors);
    if (error.data?.errors) {
      const first = Object.values(error.data.errors)[0];
      return Array.isArray(first) ? first[0] : first;
    } else {
      return error.data?.message || "Failed to add registration.";
    }
  }
}

export async function addMotorRepo(motor: any) {
  try {
    return await $fetch("http://localhost:8000/api/public/motor_repo", {
      method: "POST",
      headers: {
        Accept: "application/json",
      },
      body: motor,
    });
  } catch (error: any) {
    console.log(error.data.errors);
    if (error.data?.errors) {
      const first = Object.values(error.data.errors)[0];
      return Array.isArray(first) ? first[0] : first;
    } else {
      return error.data?.message || "Failed to add motor repo.";
    }
  }
}

export async function addVehicleRegistration(vehicleRegistration: any) {
  try {
    return await $fetch(
      "http://localhost:8000/api/public/vehicle_registration",
      {
        method: "POST",
        headers: {
          Accept: "application/json",
        },
        body: vehicleRegistration,
      },
    );
  } catch (error: any) {
    console.log(error.data.errors);
    if (error.data?.errors) {
      const first = Object.values(error.data.errors)[0];
      return Array.isArray(first) ? first[0] : first;
    } else {
      return error.data?.message || "Failed to add vehicle registration.";
    }
  }
}
