export async function deleteVehicleRegistration(id: number | string) {
  return await $fetch(
    `http://localhost:8000/api/public/vehicle_registration/${id}`,
    {
      method: "DELETE",
    },
  );
}
