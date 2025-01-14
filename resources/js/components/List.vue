<template>
    <div class="container mt-4">

        <h3 class="mb-4 h2">Un-Assigned Player List</h3>

        <div class="">
            <template v-if="players && players.length > 0">
                <vuedraggable v-model="players" :group="{  pull: 'clone', put: false }"
                    class="list-group" @end="onDropPlayer">
                    <template #item="{ element }">
                        <li class="list-group-item">
                            <strong>{{ element.name }}</strong><br>
                            <span>Email: {{ element.email }}</span><br>
                            <span>Date of Birth: {{ element.date_of_birth }}</span>
                        </li>
                    </template>
                </vuedraggable>
            </template>

            <template v-else>
                <h2 class="h4">Players not found</h2>
            </template>
        </div>

        <div class="container mt-4">
            <h1 class="mb-4" style="font-size: 36px">Teams</h1>

            <div class="row">
                <template v-if="teams && teams.length > 0">
                    <div v-for="team in teams" :key="team.id" class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><strong>Team: </strong>{{ team.name }}</h5>
                                <p class="card-text"><strong>State:</strong> {{ team.state }}</p>
                                <p class="card-text"><strong>Country:</strong> {{ team.country }}</p>

                                <div>
                                    <h6 class="mt-3"><strong>Players:</strong></h6>
                                    <vuedraggable v-model="team.players"
                                        :group="{ pull: true, put: true }" class="list-group">
                                        <template #item="{ element }">
                                            <li class="list-group-item mt-3">
                                                {{ element.name }}
                                                <button @click="removePlayerFromTeam(team, element)"
                                                    class="btn btn-danger btn-sm float-right">Delete</button>
                                            </li>
                                        </template>
                                    </vuedraggable>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <h2 class="h4">Teams not found</h2>
                </template>
            </div>
            <template v-if="teams && teams.length > 0">
            <button @click="savePlayerOrder" class="btn btn-primary mt-4">Save Player Order</button>
            </template>

            <div class="mt-5"></div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import vuedraggable from 'vuedraggable';
const players = ref([]);
const error = ref(null);
const teams = ref([]);

const fetchPlayers = async () => {
    try {
        const response = await fetch('http://127.0.0.1:8000/api/players');
        if (!response.ok) {
            throw new Error('Failed to fetch players');
        }
        players.value = await response.json();
    } catch (err) {
        error.value = err.message;
    }
};

const fetchTeams = async () => {
    try {
        const response = await fetch('http://127.0.0.1:8000/api/teams');
        teams.value = await response.json();
    } catch (err) {
        error.value = err.message;
    }
};

onMounted(() => {
    fetchPlayers();
    fetchTeams();
});

const updatePlayerStatus = async (player) => {
    try {
        const responseAdd = await fetch(`http://127.0.0.1:8000/api/update-player-status/${player}`);
        fetchPlayers()

    } catch (err) {
        error.value = err.message;
    }
};

const onDropPlayer = async (event) => {
    const player = event;
    var id = player.item._underlying_vm_.id

    await updatePlayerStatus(id);

};


const removePlayerFromTeam = async (team, player) => {
    try {
        const index = team.players.findIndex(p => p.id === player.id);
        if (index !== -1) {
            team.players.splice(index, 1);
        }

        const responseRemove = await fetch(`http://127.0.0.1:8000/api/delete-player/${player.id}`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ team_id: team.id })
        });
        fetchPlayers();

        Swal.fire({
            title: "Player removed from team",
            icon: "success",
            draggable: true
        });
    } catch (err) {
        error.value = err.message;
    }
};

const savePlayerOrder = async () => {
    const updatedTeamsPlayers = teams.value.map(team => ({
        team_id: team.id,
        players: team.players.map((player, index) => ({
            id: player.id,
            sort_order: index + 1,
        })),
    }));


    try {
        const response = await fetch('http://127.0.0.1:8000/api/save-teams', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ teams: updatedTeamsPlayers }),
        });

        Swal.fire({
            title: "All player orders saved successfully.",
            icon: "success",
            draggable: true
        });
    } catch (err) {
        error.value = err.message;
    }
};
</script>
