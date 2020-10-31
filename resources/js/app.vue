<template>
    <div>
        <div id="header">
            <button @click="generate(1)">New</button>
        </div>

        <div id="content">
            <div class="spiral" v-for="(data,index) in datas" :key="data.id" v-show="load">
                <label>Flag: {{data.flag}}</label>
                <p :class="['p'+index]">{{data.values}}</p>
            </div>
                <div class="loader" v-show="!load">
                </div>
        </div>
        

    </div>
</template>


<script>
    export default {
        data() {
            return {
                newdata : {
                    data : []
                },
                datas : [],
                load : false
            }
        },
        methods:
        {
            generate(status)
            {
                this.load = false;
                this.newdata.data = [];
                var num_random = Math.floor(Math.random() * (10 - 5) + 5);
                for(let i=0; i < num_random;i++)
                {
                    var characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                    var numbers = "0123456789";
                    var num_breakdown = Math.floor(Math.random() * (10 - 5) + 5);
                    let random_value = "";
                    let random_id = "";
                    let breakdown_values = {};

                     //for random id
                    for(let y= 0;y < 5 ;y++)
                    {
                        let random_number = numbers.charAt(Math.floor(Math.random() * numbers.length));
                        random_id += random_number;
                    }

                    //for random values
                    for(let y= 0 ; y < 5 ; y++)
                    {
                        let random_char = characters.charAt(Math.floor(Math.random() * characters.length));
                        random_value += random_char;
                    }

                    //for breakdown values
                    for(let x = 0;x < num_breakdown;x++)
                    {
                        let temp_bvalue = "";
                        for(let y= 0 ; y < 5 ; y++)
                        {
                            let breakdown_char = characters.charAt(Math.floor(Math.random() * characters.length));
                            temp_bvalue += breakdown_char;
                        }  
                        breakdown_values[x] = temp_bvalue;
                    }
                    let tempdata =
                    {
                        random_value : random_value,
                        random_id : random_id,
                        breakdowns : breakdown_values
                    }

                    this.newdata.data.push(tempdata);
                }

                this.axios.post(`http://localhost:8000/api/generate`,this.newdata)
                    .then(response =>{
                            if(status == 1)
                            {
                                swal({
                                    title: "Success!",
                                    text: "Success!",
                                    icon: "Success",
                                }).then((value) => {
                                        window.location.href = "/";
                                    });
                            }
                        })
            },
            display()
            {
                this.load = false;
                this.axios.get(`http://localhost:8000/api/retrievedata`,this.newdata)
                    .then(response =>{
                        this.datas = response.data;
                        setInterval(this.displayspiral, 2000);
                    })
            },
            spiraldesign (options = {target: undefined,span: 100,north: 0,spiral: false})
            {
                    const {target,span,north,spiral,size} = options;
                        const message = target.textContent;
                        const quaterWidth = target.clientWidth / 4;
                        const diameter = size;// || quaterWidth;
                        const messageChunks = message.split(String());
                        const { length } = messageChunks;
                        const offsetEnd = 1;
                        const l = length + offsetEnd;
                        const CIRC_MAX = 360;
                        const PERC_MAX = 100;
                        const ofDeg = span * CIRC_MAX / PERC_MAX;
                        const ofNorth = north * CIRC_MAX / PERC_MAX;
                        const segDeg = ofDeg / l;
                        const fontSize = 16;
                        let a = 0;
                        let i = 0;
                        
                        target.setAttribute('style', `
                            padding-left: ${diameter / 2}px;
                            display: inline-block;
                            width: ${diameter / 2}px;
                            height: ${diameter}px;
                            transform: rotate3d(0, 0, 1, -${segDeg + ofNorth}deg);
                            border-radius: 9e9em;
                            font-size: 1rem;
                        `);
                        target.classList.add('fx-Revolve');
                        target.textContent = '';
                        while (a < ofDeg) {
                            a += segDeg;
                            const charWrapper = document.createElement('span');
                            charWrapper.textContent = messageChunks[i];
                            i ++;
                            charWrapper.classList.add('fx-RevolveCharWrap');
                            charWrapper.setAttribute('style', `
                                display: inline-block;
                                transform: 
                                    rotate3d(0, 0, 1, ${a}deg) 
                                    ${spiral ? 'translateY(' + (i) + 'px)': ''};
                                ${spiral ? 'font-size:' + (fontSize - (i / 10) ) + 'px': ''};
                                position: absolute;
                                height: ${diameter / 2}px;
                                transform-origin: bottom left;
                                font-size: 1em;
                            `);
                            target.appendChild(charWrapper);
                        }
            },
            displayspiral()
            {
                for(let x=0; x < this.datas.length;x++)
                {
                        this.spiraldesign({
                            target: document.querySelector('.p'+x),
                            span: 800,
                            north: 10,
                            spiral: true,
                            size:1000
                        });
                }
                this.load = true;
            }
        },
        created()
        {   
            this.display();
            
            if(this.datas.length > 0)
            {
                 this.generate(0);
            }
        }
    }
</script>