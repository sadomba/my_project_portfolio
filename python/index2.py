def arbitrage_betting(odd1, odd2, odd3, total_stake):
    # Calculate the arbitrage percentage
    arb_percentage = (1 / odd1) + (1 / odd2) + (1 / odd3)
    
    # Calculate the stakes for each bet
    stake1 = (total_stake / (odd1 * arb_percentage))
    stake2 = (total_stake / (odd2 * arb_percentage))
    stake3 = (total_stake / (odd3 * arb_percentage))
    
    # Calculate the total payout for each outcome
    total_payout1 = stake1 * odd1
    total_payout2 = stake2 * odd2
    total_payout3 = stake3 * odd3
    
    # Calculate the profit
    total_payout = total_payout1  # Since all payouts should be the same in arbitrage
    profit = total_payout - total_stake
    
    return {
        'Stake 1': stake1,
        'Stake 2': stake2,
        'Stake 3': stake3,
        'Total Payout': total_payout,
        'Profit': profit
    }

# Given values
odd1 = 2.8
odd2 = 3.8
odd3 = 3.2
total_stake = 100

# Calculate arbitrage betting stakes and profit
result = arbitrage_betting(odd1, odd2, odd3, total_stake)

print(f"Stake on odd 1: ${result['Stake 1']:.2f}")
print(f"Stake on odd 2: ${result['Stake 2']:.2f}")
print(f"Stake on odd 3: ${result['Stake 3']:.2f}")
print(f"Total Payout: ${result['Total Payout']:.2f}")
print(f"Profit: ${result['Profit']:.2f}")
