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
