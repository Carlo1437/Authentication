export async function getVehicleRegistration() {
  const response = await $fetch(
    `http://localhost:8000/api/public/vehicle_registration`,
    {
      method: "GET",
    },
  );
  return response.data;
}