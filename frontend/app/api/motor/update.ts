export async function approveVehicleRegistration(id: number | string) {
  return await $fetch(
    `http://localhost:8000/api/public/vehicle_registration/${id}`,
    {
      method: "PUT",
      body: { status: "approved" },
    },
  );
}


